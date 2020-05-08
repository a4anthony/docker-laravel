<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="color:#333;">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Items</th>
                        @isset($address)
                        @else
                        <th>Total</th>
                        @endisset
                        @isset($user)
                        <th>Status</th>
                        @endisset
                        @isset($address)
                        @else
                        <th>Actions</th>
                        @endisset
                    </tr>
                </thead>

                <tbody>

                    @foreach ($allOrders as $key => $orders)
                    @foreach ($orders as $key => $order)
                    @php
                    $key = $key + 1;
                    @endphp

                    @if ($key ==1 )
                    <tr>
                        <td>
                            {{$order->reference}}
                        </td>

                        <td>
                            @foreach ($order->products($order) as $product)
                            <p> - {{ $product->title}} <span style="font-weight: 700;">({{$order->quantity($order, $product)}}) </span> at
                                <span style="font-weight: 700;">&#8358;{{$order->price($order, $product)}}</span></p>
                            @endforeach
                        </td>


                        @isset($address)
                        @else

                        <td>
                            <p> <span>&#8358;</span>{{$order->total($order)}}</p>
                        </td>

                        @endisset
                        @isset($user)
                        <td>
                            <p>{{$order->order_status}}</p>
                        </td>
                        @endisset

                        @isset($address)
                        @else

                        <td id="actionBtn" class="text-center my-auto">
                            <a href="/order/{{$order->reference}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                        </td>

                        @endisset
                    </tr>
                    @endif
                    @endforeach
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>