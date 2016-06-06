
<div width="100" class="white_background">
    <h1>{{$ingredient->title()}}</h1>
    <img src="{{$ingredient->thumbnail_small}}" alt="{{$ingredient->title()}}">
    <p>{{$ingredient->description()}}</p>
</div>

<style>
    .white_background{
        background-color:white;
    }
</style>