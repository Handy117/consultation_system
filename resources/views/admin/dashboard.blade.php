@extends('layouts.dashboard')
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-users"></i>&nbsp;Consultant Dashboard</h1>
        <!-- <p>A free and open source Bootstrap 4 admin template</p> -->
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Consultant Dashboard</a></li>
    </ul>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="col-md-12">
                    <form action="" method="POST" class="form-inline">
                        @csrf 
                        <label class="control-label mr-sm-2 mb-2" for="period">Type Of Issue: </label>
                        <select class="form-control form-control-sm mr-sm-3 mb-2" name="category_id" id="search_category">
                            <option value="">Select a type of issue</option>
                            @foreach ($categories as $item)
                                <option value="{{$item->id}}" @if ($category_id == $item->id) selected @endif>{{$item->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label mr-sm-2 mb-2" for="period">Status: </label>
                        <select class="form-control form-control-sm mr-sm-3 mb-2" name="status" id="search_status">
                            <option value="">Select a Status</option>
                            <option value="0" @if ($status == '0') selected @endif>Pending</option>
                            <option value="1" @if ($status == '1') selected @endif>Accepted</option>
                            <option value="2" @if ($status == '2') selected @endif>Closed</option>                            
                        </select>
                        <label class="control-label mr-sm-2 mb-2" for="period">Requested Time: </label>
                        <input type="text" class="form-control form-control-sm col-md-2 mr-sm-2 mb-2" name="period" id="period" autocomplete="off" value="{{$period}}">
                        <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;Search</button>
                        <button type="button" class="btn btn-sm btn-info mb-2 ml-3" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;Reset</button>
                    </form>
                </div>
                <div class="tile-body mt-3">
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>UserID</th>
                                <th>Type of Issue</th>
                                <th>Subject</th>
                                <th>Consultant</th>
                                <th>Status</th>
                                <th>Requested Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>    
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <input type="hidden" class="description" value="{{$item->description}}">
                                <input type="hidden" class="answer" value="{{$item->answer}}">
                                <input type="hidden" class="attachment" @isset($item->attachment->path) data-value="{{basename($item->attachment->path)}}" data-ext="{{pathinfo($item->attachment->path, PATHINFO_EXTENSION)}}" value="{{$item->attachment->path}}" @endif />
                                <td>{{ ($page_number-1) * 10 + $loop->index+1 }}</td>
                                <td class="user_id">{{$item->user->name}}</td>
                                <td class="category">{{$item->category->name}}</td>
                                <td class="subject">{{$item->subject}}</td>
                                <td class="consultant">@isset($item->consultant->name) {{$item->consultant->name}} @endisset</td>
                                <td class="status">
                                    @if ($item->status == 2)
                                        <span class="text-danger">Closed</span>
                                    @elseif($item->status == 1)
                                        <span class="text-success">Accepted</span>
                                    @else
                                        <span class="text-muted">Pending</span>
                                    @endif
                                </td>
                                <td class="timestamp">{{$item->created_at}}</td>
                                <td class="action py-2">
                                    <a href="#" class="btn btn-info btn-sm btn-view" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View"><i class="fa fa-info-circle" style="font-size:20px"></i>View</a>
                                    <a href="{{route('question.delete', $item->id)}}" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Are you sure?');" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Delete"><i class="fa fa-trash-o" style="font-size:20px"></i>&nbsp;Delete</a>                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="pull-left" style="margin: 0;">
                            <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                        </div>
                        <div class="pull-right" style="margin: 0;">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Question Detail</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
                <div class="modal-body p-5">
                    <div class="row mb-2">
                        <label class="col-sm-3 text-right">Subject :</label>
                        <label class="col-sm-9 subject"></label>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 text-right">Type Of Issue :</label>
                        <label class="col-sm-9 category"></label>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 text-right">Description :</label>
                        <pre class="col-sm-9 description"></pre>
                    </div>
                    
                    <div class="row mb-2">
                        <label class="col-sm-3 text-right">Attachment :</label>
                        <div class="col-sm-9 attachment"><a href="" download></a></div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 text-right">Status :</label>
                        <label class="col-sm-9 status"></label>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('script')

<script>
    $(document).ready(function () {
        var public_path = "{{asset('')}}";
        
        $(".btn-view").click(function(){
            let id = $(this).data('id');
            let category = $(this).parents('tr').find(".category").text();
            let subject = $(this).parents('tr').find(".subject").text();
            let consultant = $(this).parents('tr').find(".consultant").text();
            let status = $(this).parents('tr').find(".status").text();
            let description = $(this).parents('tr').find(".description").val().trim();
            let answer = $(this).parents('tr').find(".answer").val().trim();
            let attachment = $(this).parents('tr').find(".attachment").val().trim();
            let filename = $(this).parents('tr').find(".attachment").data('value');
            let extention = $(this).parents('tr').find(".attachment").data('ext');
            $("#viewModal .field").text('');
            $("#viewModal .category").text(category);
            $("#viewModal .subject").text(subject);
            $("#viewModal .consultant").text(consultant);
            $("#viewModal .status").text(status);
            $("#viewModal .description").text(description);
            $("#viewModal .answer").text(answer);
            $("#viewModal .attachment a").attr("href", public_path + attachment);
            let image_array = ['jpg', 'jpeg', 'gif', 'png'];
            let doc_array = ['doc', 'docx', 'xlsx', 'ppt'];
            let audio_array = ['mp3', 'ogg', 'wav'];
            let video_array = ['avi', 'mpg', 'mp4'];
            let content = ''
            if(image_array.indexOf(extention) > -1){
                content = `<img width="100" src="${public_path + attachment}">`;
            }else if(doc_array.indexOf(extention) > -1){
                content = '<img src="' + public_path + 'images/word.png' + '">';
            }else if(audio_array.indexOf(extention) > -1){
                content = `<audio style="width:300px;height:40px;" controls><source src="${public_path+attachment}"></audio>`;
            }else if(video_array.indexOf(extention) > -1){
                content = `<video width="160" height="120" controls><source src="${public_path+attachment}"></video>`;
            }else{
                content = filename;
            }
            $("#viewModal .attachment a").html(content);            
            $("#viewModal").modal();
        });

        
        $("#btn-reset").click(function(){
            $("#search_category").val('');
            $("#search_status").val('');
            $("#period").val('');
        });
    });
</script>
@endsection