<div class="col-md-12">
    <div class="wrapper">
        <div class="landing_container">
            <h1 class="capital center width_55 white" id="landing_text">{{$hero->title()}}</h1>
            <a class="capital center white" id="landing_link" href="#products">{{trans('text.our_products')}}</a>    
        </div>
        
        <video poster="{{asset($hero->image)}}" id="landing_video" width="100%" >
          <source src="{{asset($hero->video)}}" type="video/mp4">
          <source src="{{asset($hero->video)}}" type="video/ogg">
        Your browser does not support the video tag.
        </video>    

    </div>
</div>
