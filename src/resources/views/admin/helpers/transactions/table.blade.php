<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Sale Price (<span>&#8358;</span>)</th>
                        <th>Rate</th>
                        <th>Comm</th>
                        <th>Shipping (<span>&#8358;</span>)</th>
                        <th>Payment Amount (<span>&#8358;</span>)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($allTransactions as $transaction)
                    <tr>
                        <td>{{$transaction->reference}}</td>
                        <td class="text-center">{{$transaction->sale_price}}</td>
                        <td class="text-center">{{$transaction->rate}}</td>
                        <td class="text-center">{{$transaction->commission}}</td>
                        <td class="text-center">{{$transaction->shipping}}</td>
                        <td class="text-center">{{$transaction->total}}</td>
                        <td id="actionBtn" class="text-center">
                            <a href="/order/{{$transaction->reference}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                        </td>
                    </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>