<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
{{$exception->getMessage()}}


<video width="640" height="360" controls preload="none">
    <source src="{{asset('errors/error_pages/grass_small.ogv')}}"  type="video/mp4" />
    <source src="{{asset('errors/error_pages/grass_small.ogv')}}"  type="video/ogg" />
</video>

<video width="640" height="360" controls preload="none">
    <source src="{{asset('errors/error_pages/bird house_small.ogv')}}"  type="video/mp4" />
    <source src="{{asset('errors/error_pages/bird house_small.ogv')}}"  type="video/ogg" />
</video>


</body>
</html>