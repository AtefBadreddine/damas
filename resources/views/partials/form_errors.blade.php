@if (count($errors))
    <div class="alert alert-danger">
        <ul style="padding-left:10px;">
            @foreach($errors->all() as $error)
                <li><?= $error; ?></li>
            @endforeach
        </ul>
    </div>
@endif