<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

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

        return [
            'id'  => $file->id,
            'time' => $file->created_at,
            'file_name' => $file->file_name,
            'status' => $show_status
        ];
    }
}
