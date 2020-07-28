@if ($errors->any())
    <style>
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
    <div class="alert alert-dismissible">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
       <span class="fas fa-exclamation-triangle"></span> <strong> ¡Advertencia!</strong>  @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>

@endif
