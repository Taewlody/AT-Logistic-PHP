<div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3>Advance Payment</h3>
                            </div>
                            <div class="col text-end">
                                <h3>{{ number_format($sum_advance_total, 2) }}</h3>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="card-body">
                        <table class="table" data-page-size="{{ $data_advance_pyment_table->total() }}">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th style="white-space: nowrap">Total Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_advance_pyment_table as $advance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $advance->customer != null ? $advance->customer->custNameTH : '' }}</td>
                                        <td>{{ number_format($advance->sumTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br/>
                        <div class="row">
                            <div class="col">
                                {{ $data_advance_pyment_table->links('layouts.themes.layout.custom-pagination-info') }}
                            </div>
                            <div class="col"> 
                                {{ $data_advance_pyment_table->links('layouts.themes.layout.custom-pagination-links') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>