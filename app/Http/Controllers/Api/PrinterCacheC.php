<?php

namespace App\Http\Controllers\Api;


use Carbon\Carbon;

use App\Models\PrinterCache;
use App\Models\Settings;
use App\Models\TableHistory;
use PDF;
use SebastianBergmann\Environment\Console;

class PrinterCacheC extends ApiController
{

    public function __construct()
    {
        $this->_model = new PrinterCache();
        $interval = Settings::GetMergeInterval();
        $this->merge_interval = $interval;
        $this->MergeAdditionalWait = 1; //minutes
    }

    public function CheckMerge()
    {   
        
        $cache = $this->_model->All();
        $tableHistories = (new TableHistory)->GetUnifishedWithOrder();
        $message = 'check completed with no merge performed';
        ##Smart check
        ##以TableHistory而不是Order作为检测，在tablehistory上添加冗余数据：
        ##last order 最后一次点单时间
        ##ordertime 点单次数（暂时不知道干啥用）
        ##（因为每5秒钟的高频率运行添加冗余数据更划算）
        ##规则：以最后一次订单为检测数据，以桌子人数为时间频率是否进行合并订单。
        #如果桌子刚刚开启，最后一次订单默认为开桌时间。而订单次数则为0
        foreach($tableHistories as $table)
        {
            if($table->merge_lock == 0)
            {   
                $num_person = ($table->num_person < 1)?1:$table->num_person;
                $person_minutes_ago = Carbon::now()->subMinutes($num_person);
                $shortwait = Carbon::now()->subMinutes($this->MergeAdditionalWait);
                if(isset($table->last_merge)==false){
                    $table->last_merge = Carbon::now();
                    $table->save();
                }
                $last_merge = Carbon::parse($table->last_merge);
                $last_order = Carbon::parse($table->last_order);
                
                if($person_minutes_ago > $last_merge && $shortwait > $last_order)
                {   
                    $message = 'check completed With no Merge and timer reset';
                    if($table->Orderque->count() > 0)
                    {
                        PrinterCache::ManualMerge($table->table->number);
                        $message = 'check completed With Merge Perfomed';
                    }
                    $table->last_merge = Carbon::now();
                    $table->save();
                }
            }
            else
            {
                $table->checkLock();
            }

        }

        #$tables = $cache->unique('table_number');
        #foreach ($tables as $table) {

        #    $table_cache = $cache->filter(function ($query) use ($table) {
        #        return $query->where('table_number', $table->table_number);
        #    });

        #    $table_clusters = $table_cache->unique('cluster_id');
        #    $cluster_count = $table_clusters->count();
        #    $x_minutes_ago = Carbon::now()->subMinutes($this->merge_interval);
        #    if ($cluster_count > 0) {
        #        if ($x_minutes_ago->gt(Carbon::parse($table_clusters[$cluster_count - 1]->created_at))) {
        #            PrinterCache::ManualMerge($table->table_number);
        #            $message = 'check completed With Merge Perfomed';
        #        }
        #    }
        #}
        return response(['message' => $message], 200);
    }

    public function ManualMerge($table_number)
    {
        PrinterCache::ManualMerge($table_number);
        return response(['message' => 'merge success'], 201);
    }

    public function GetPrintQueue()
    {
        $QueueList = $this->_model->where('status', 0)->select('id', 'printer')->get();
        $this->_model->where('status', 0)->select('id', 'printer')->update(['status' => 1]);
        return $QueueList;
    }
}
