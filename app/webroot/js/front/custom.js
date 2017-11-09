// STICKY HEADER //
$(window).scroll(function () {
  if ($(document).scrollTop() == 0) {
	$('.header').removeClass('sticky-header');
  } else {
	$('.header').addClass('sticky-header');
  }
});

// STICKY HEADER MENU PUSH //
$(document).ready(function() {
	$('#nav_list').click(function(){
		$('.header').toggleClass('push-header-left');
	});
});




$(document).ready(function() {
	$menuLeft = $('.pushmenu-left');
	$nav_list = $('#nav_list');
	
	$nav_list.click(function() {
		$(this).toggleClass('active');
		$('.pushmenu-push').toggleClass('pushmenu-push-toright');
		$menuLeft.toggleClass('pushmenu-open');
	});
});

$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });
});


(function(window){

	// get vars
	var searchEl = document.querySelector("#input");
	var labelEl = document.querySelector("#label");
console.log(labelEl);
if(labelEl!=null){
	//alert('ok');
	// register clicks and toggle classes
	labelEl.addEventListener("click",function(){
		if (classie.has(searchEl,"focus")) {
			classie.remove(searchEl,"focus");
			classie.remove(labelEl,"active");
		} else {
			classie.add(searchEl,"focus");
			classie.add(labelEl,"active");
		}
	});

	// register clicks outisde search box, and toggle correct classes
	document.addEventListener("click",function(e){
		var clickedID = e.target.id;
		if (clickedID != "search-terms" && clickedID != "search-label") {
			if (classie.has(searchEl,"focus")) {
				classie.remove(searchEl,"focus");
				classie.remove(labelEl,"active");
			}
		}
	});
}
}(window));

$(document).ready(function(){
    $(".comment-btn").click(function(){
        $(".comment-list").slideToggle( "slow" );
    });
});


//************************** FLIPER BOX ****************/
(function() {
  var cards = document.querySelectorAll(".card.effect__click");
  for ( var i  = 0, len = cards.length; i < len; i++ ) {
    var card = cards[i];
    clickListener( card );
  }

  function clickListener(card) {
    card.addEventListener( "click", function() {
      var c = this.classList;
      c.contains("flipped") === true ? c.remove("flipped") : c.add("flipped");
    });
  }
})();