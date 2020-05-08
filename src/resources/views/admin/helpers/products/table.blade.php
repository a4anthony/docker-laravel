<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Title</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($allProducts as $product)
                    <tr>
                        <td>7y79uh45u7457458</td>
                        <td>{{$product->title}}</td>
                        <td class="text-center"><span>&#8358;</span>{{$product->total_price}}</td>
                        <td class="text-center">{{$product->quantity}}</td>
                        <td class="text-center">{{$product->discount}}</td>
                        <td id="actionBtn" class="text-center margin: auto 0;">
                            <a href="/product/{{$product->id}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                        </td>
                    </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>