(function($) {
    "use strict";

   console.log($)
   let type = $('.js-type').attr('name');
   const id_prev = $('.js-tab-prev').attr('id');
   const id_next = $('.js-tab-next').attr('id');

   // $('.js-tab-prev').html('<strong>SAMPE</strong>');
   if(type == 'nba.players'){
	   	type = 'nba';
   }

   if(id_prev !== undefined){
  	 let url = `/api/players/${type}?id=${id_prev}`
  	 const data = getData(url);
  	 data.then((data) =>{
  	 	
	  	 $('.js-tab-prev').html(`<strong>${data.full_name}</strong>`);
	  	 $('.js-cache-prev').val(JSON.stringify(data))
  	 })
   }

   if(id_next !== undefined){
  	 let url = `/api/players/${type}?id=${id_next}`
  	 const data = getData(url);
  	 data.then((data)=>{
  	 		console.log(data)
	  	 $('.js-tab-next').html(`<strong>${data.full_name}</strong>`);
	  	 $('.js-cache-next').val(JSON.stringify(data)) 
  	 })
   }

   async function getData(url){
  	 const data = await fetch(url).then(res => res.json()).then(res=>{return res});
  	 return data;
   }


   $('.js-tab').click(function(e){
   		$('.js-tab').removeClass('active');
   		$(this).addClass('active');
   		const className = $(this).attr('cache');
   		const cache     = $(className).val();
   		const data      = JSON.parse(cache);
   		ajaxRender(data)
   });

   function ajaxRender(data){
			const featured = data.featured.map((data)=>{
				return `
					<div class="feature">
              <h3>${data.label}</h3>
              ${data.value}
          </div>
				`
			})

			const bio = data.bio.map((data)=>{
				return `
					<div class="data">
            <strong>${data.label}</strong>
             ${data.value}
        </div>
				`
			});
			$('.js-featured').html(featured);
			$('.js-bio').html(bio);
   		$('.js-first-name').html(data.first_name);
   		$('.js-last-name').html(data.last_name);
			$('.js-number').html(`#${data.number}`);
			$('.js-image').attr('src',`/static/images/players/${data.image}`);

   }
}(jQuery));
