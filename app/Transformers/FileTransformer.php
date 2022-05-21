<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class FileTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($file)
    {
        switch ($file->status) {
            case 0:
                $show_status = '<span class="badge badge-secondary">Pending</span> <div class="spinner-border  spinner-border-sm" role="status"><span class="sr-only"></span></div>'; //Pending
                break;
            case 1:
                $show_status = '<span class="badge badge-primary">Processing</span> <div class="spinner-border  spinner-border-sm text-primary" role="status"><span class="sr-only"></span></div>'; //Processing
                break;
            case 2:
                $show_status = '<span class="badge badge-success">Completed</span>'; // Completed
                break;
            case 3:
                $show_status = '<span class="badge badge-danger">Failed</span>'; // Failed
                break;
            default:
                $show_status = '<span class="badge badge-danger">Error</span>'; // Error
        }


        $result = Carbon::now()->diffForHumans(Carbon::create($file->created_at));
        $time_diff = "<small>(".str_replace("after","ago",$result).")</small>";
        if(str_contains($result, 'seconds')){
            $time_diff = "<small>(Just now)</small>";
        }
        
        $time = Carbon::create($file->created_at)->format('Y-m-d')." ".Carbon::create($file->created_at)->format('H:i A')." ".$time_diff;

        return [
            'id'  => $file->id,
            'time' => $time,
            'file_name' => $file->file_name,
            'status' => $show_status
        ];
    }
}
