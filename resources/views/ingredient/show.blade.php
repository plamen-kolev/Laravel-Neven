
<div class="ingr-pop">
    <img class="ingr_pop_img" src="{{route('image', $ingredient->thumbnail)}}?w=150&h=150&fit=crop" alt="{{$ingredient->title()}}" >
    <h1>{{$ingredient->title()}}</h1>
    <p>{{$ingredient->description()}}</p>
</div>

