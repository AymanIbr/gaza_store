<x-dashboard title="Notifications">

    <h1 class="h3 mb-4 text-gray-800">All Notifications</h1>


    <div class="list-group">
       @foreach ( Auth::user()->notifications as $item )
       <a href="#" class="list-group-item list-group-item-action" style="{{ $item->read_at ? '' : 'background: rgb(229, 229, 229)' }}" aria-current="true">
        {{ $item->data['msg'] }}
      </a>
       @endforeach
      </div>

</x-dashboard>
