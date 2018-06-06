<ul class="media-list">
@foreach ($kadaitasklists as $kadaitasklist)
    <?php $user = $kadaitasklist->user; ?>
    <li class="media">
        <div class="media-left">
            <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
        </div>
        <div class="media-body">
            <div>
                {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $kadaitasklist->created_at }}</span>
            </div>
            <div>
                <p>ステータス : {!! nl2br(e($kadaitasklist->status)) !!}</p>
                <p>タスク : {!! nl2br(e($kadaitasklist->content)) !!}</p>
            </div>
            <div>
                   
                @if (Auth::user()->id == $kadaitasklist->user_id)
                    
                    {!! Form::open(['route' => ['kadaitasklists.destroy', $kadaitasklist->id], 'method' => 'delete']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                    
                    {!! link_to_route('kadaitasklists.edit', 'このタスクを編集', ['id' => $kadaitasklist->id], ['class' => 'btn btn-default']) !!}
                @endif
                
            </div>
        </div>
    </li>
@endforeach
</ul>
{!! $kadaitasklists->render() !!}