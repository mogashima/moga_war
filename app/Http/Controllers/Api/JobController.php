<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Types\JobType;

class JobController extends Controller
{
    /**
     * 職業一覧を取得
     */
    public function index()
    {
        $jobs = [];

        foreach (JobType::cases() as $job) {
            $jobs[$job->name] = $job->value;
        }

        return $this->jsonResponse($jobs);
    }
}
