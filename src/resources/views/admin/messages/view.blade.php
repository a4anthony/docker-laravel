@extends('admin.messages.index')
@section('title')
<title>Read Messages</title>
@endsection

@section('links')
<a class="pause d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="" onclick="event.preventDefault();
                                document.getElementById('update').submit();">Mark as unread</a>
<a class="delete d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="" data-toggle="modal" data-target="#deleteModal">Delete</a>
@endsection
<!-- Content Wrapper -->
@section('view')
<style>
    .message_header {
        display: none;
    }

    .subHeading {
        text-transform: uppercase;
        font-size: .7rem;
        font-weight: 400;
    }
</style>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete message?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="" onclick="event.preventDefault();
                                document.getElementById('delete').submit();">
                    Yes</a>
                <form id="delete" action="/message/delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="number" name="message_id" hidden value="{{$message->id}}">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span class="subHeading">Subject:</span> {{$message->subject}}<br>
                <span class="subHeading">From :</span> {{$message->name}} [{{$message->email}}]<br>
                <span class="subHeading">Date:</span> {{$message->created_at}}
            </h6>
        </div>
        <div style="padding: 1rem; color: #333">
            <p>{{$message->message}}</p>
        </div>


    </div>

</div>

<form id="update" action="/message/unread" method="POST">
    @csrf
    @method('PUT')
    <input type="number" name="message_id" hidden value="{{$message->id}}">
</form>
@endsection