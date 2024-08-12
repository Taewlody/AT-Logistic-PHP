<div class="row" wire:ignore.self>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3>Job Inprocess</h3>
            </div>
            <div class="card-body">
                <table class="table" data-page-size="{{ $data_job_inprocess->total() }}">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job No.</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Bound</th>
                            <th>Port</th>
                            <th>Sales</th>
                            <th style="white-space: nowrap">Time period (Day)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_job_inprocess as $job)
                        <tr>
                            <td>{{ $loop->iteration + (($data_job_inprocess->currentPage() - 1) * $data_job_inprocess->perPage()) }}</td>
                            <td>{{ $job->documentID }}</td>
                            <td>{{ $job->documentDate }}</td>
                            <td>{{ $job->customerRefer != null ? $job->customerRefer->custNameEN : '' }}</td>
                            <td>{{ $job->bound ? $job->bound === '1' ? 'IN BOUND' : 'OUT BOUND' : '' }}</td>
                            <td>{{ $job->landingPort != null ? $job->landingPort->portNameEN : '' }}</td>
                            <td>{{ $job->salemanRefer != null ? $job->salemanRefer->empName : '' }}</td>
                            <td class="text-center">
                                {{ (new DateTime($job->documentDate))->diff(new DateTime('now'))->format("%r%a")}}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('job-order.form', ['action' => 'view', 'id' => $job->documentID]) }}" wire:navigate>
                                    <i class="fa fa-search text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br/>
                <div class="row">
                    <div class="col-4">
                        {{ $data_job_inprocess->withQueryString()->links('layouts.themes.layout.custom-pagination-info') }}
                    </div>
                    <div class="col-8"> 
                        {{ $data_job_inprocess->withQueryString()->links('layouts.themes.layout.custom-pagination-links') }}
                    </div>
                </div>
                        
            </div>
        </div>
    </div>
</div>