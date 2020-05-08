<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
               
                <tbody>

                    @foreach ($allMessages as $message)
                    @if ($message->status == 1)
                    <tr>

                        <td>{{$message->subject}}</td>
                        <td>{{$message->name}}</td>
                        <td>{{$message->email}}</td>
                        <td>
                            <?php
                            if (strlen($message->message) > 50) {
                                $message->message = substr($message->message, 0, 50) . '...';
                            }
                            echo $message->message;
                            ?>
                        </td>
                        <td>{{$message->created_at->format('d/m/y')}}</td>


                        <td id="actionBtn" class="text-center">
                            <a href="/message/{{$message->id}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                        </td>
                    </tr>
                    @else
                    <tr style="color: black; font-weight:600;">

                        <td>{{$message->subject}}</td>
                        <td>{{$message->name}}</td>
                        <td>{{$message->email}}</td>
                        <td>
                            <?php
                            if (strlen($message->message) > 50) {
                                $message->message = substr($message->message, 0, 50) . '...';
                            }
                            echo $message->message;
                            ?>
                        </td>
                        <td>{{$message->created_at->format('d/m/y')}}</td>


                        <td id="actionBtn" class="text-center">
                            <a href="/message/{{$message->id}}" class="edit btn btn-sm btn-primary shadow-sm"><i></i>View</a>
                        </td>
                    </tr>
                    @endif
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>