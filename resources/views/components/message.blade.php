<div>
    @if (session()->has('success'))
        <div class="notification is-success mb-2">
            <i class="fas fa-smile"></i> {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="notification is-danger mb-2">
            <i class="fas fa-exclamation-triangle"></i> <b>Correct the following error(s) before
                continuing!</b>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
</div>
