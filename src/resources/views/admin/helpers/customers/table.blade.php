<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($allCustomers as $customer)
                    <tr>
                        <td>{{$customer->id}}</td>
                        <td>{{$customer->firstname}} {{$customer->lastname}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->phone}}</td>
                        <td id="actionBtn" class="text-center">
                            <a href="/orders/{{$customer->id}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                        </td>
                    </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>