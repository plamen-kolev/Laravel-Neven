<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
{{$exception->getMessage()}}


<video width="640" height="360" controls preload="none">
    <source src="{{asset('images/error_pages/400.mp4')}}"  type="video/mp4" />
    <source src="{{asset('images/error_pages/400.mp4')}}"  type="video/ogg" />
</video>


</body>
</html>