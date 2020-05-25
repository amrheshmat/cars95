<html  lang="en" data-textdirection="rtl">
    <body > 
        {!! Form::open(['url'=> $data['paymentGatewayURL'],'id'=> 'initiationForm','method'=>'POST' ])!!}
            {{ Form::hidden('SenderID', $data['SenderID'], ['class' => 'form-control', 'placeholder' => 'SenderID']) }}
            {{ Form::hidden('RandomSecret', $data['RandomSecret'], ['class' => 'form-control', 'placeholder' => 'SenderID']) }}
            {{ Form::hidden('RequestObject', $data['RequestObject'], ['class' => 'form-control', 'placeholder' => 'SenderID']) }}
            {{ Form::hidden('HasedRequestObject', $data['HasedRequestObject'], ['class' => 'form-control', 'placeholder' => 'SenderID']) }}
        {!! Form::close()!!}
        <script src="{{ asset('/plugins/jquery/dist/jquery.min.js') }}"></script>

        <script type="text/javascript">
            $( document ).ready(function() { 
                $("#initiationForm").submit();
            });
        </script>
    </body>
</html>

