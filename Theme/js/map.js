 var fmr_map_init_obj = {"lat":"","longu":"","zum":"13","ajaxurl":"http:\/\/city1.vioo.ru\/wp-admin\/admin-ajax.php","direct":"http:\/\/city1.vioo.ru\/wp-content\/themes\/mycity","weather_latitude":"44.157265","weather_longitude":"-92.073552","hide_paralax":"","weather":"s2"};
    var mapObject,
            markers = [],
            markersData = {
               'men': [
                            
          
                                         {
            name: 'alextest2',
            location_latitude: 37.466059,
            location_longitude: -122.259102,
            map_image_url: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIb9mHUq8Tz1UMdwMcsDfc3SRPL_F5augLIQApA317p8vWqb2B',
            name_point: 'alextest2',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/203.png',

            description_point: 'Working hard and working smart sometimes can be two different things.',
            url_point: 'http://freelance.vioo.ru/members/9/ '
            },
                                                   {
            name: 'amanda',
            location_latitude: 37.467059,
            location_longitude: -122.248102,
            map_image_url: 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTEQ0gLCs9wZFMxMBY8-Vt1llqJKgAdwB8BLj-YveQIjVn3GdWn',
            name_point: 'amanda',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/203.png',

            description_point: 'By working faithfully eight hours a day you may eventually get to be boss and work twelve hours a day.',
            url_point: 'http://freelance.vioo.ru/members/47/ '
            },
                                                   {
            name: 'Anettc',
            location_latitude: 37.470059,
            location_longitude: -122.257102,
            map_image_url: 'http://blonde.eu/wp-content/uploads/2014/12/Gudrun-Somers_Senior-Creative-Designer1.jpg',
            name_point: 'Anettc',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/204.png',

            description_point: 'The best preparation for good work tomorrow is to do good work today.',
            url_point: 'http://freelance.vioo.ru/members/46/ '
            },
                                                   {
            name: 'arbuz',
            location_latitude: 37.464059,
            location_longitude: -122.261102,
            map_image_url: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4YSurlNcv-v40E3wy5mOa9hHnekGBt_tvyRhMr08bRfRfsyZCIw',
            name_point: 'arbuz',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/204.png',

            description_point: 'The best preparation for good work tomorrow is to do good work today.',
            url_point: 'http://freelance.vioo.ru/members/10/ '
            },
                                                   {
            name: 'Baba Doynaya',
            location_latitude: 37.476059,
            location_longitude: -122.253102,
            map_image_url: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIwIX4Dq-dj_sqEoZ-IV27Umgm7Cg2eH7efijA7zkpecyVIXKkZA',
            name_point: 'Baba Doynaya',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/204.png',

            description_point: 'The best preparation for good work tomorrow is to do good work today.',
            url_point: 'http://freelance.vioo.ru/members/11/ '
            },
                                                   {
            name: 'bilous-victor',
            location_latitude: 37.477059,
            location_longitude: -122.255102,
            map_image_url: 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSQxMondllNqRSMAJFcvnQfQ0NaC77np3Z-u8CAvhTVkVOBdlCdCw',
            name_point: 'bilous-victor',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/205.png',

            description_point: 'The beginning is the most important part of the work.',
            url_point: 'http://freelance.vioo.ru/members/12/ '
            },
                                                   {
            name: 'chipbennett',
            location_latitude: 37.461059,
            location_longitude: -122.262102,
            map_image_url: 'http://www.3dshoerepairs.co.uk/sites/default/files/Dolce-Gabbana-edit.jpg',
            name_point: 'chipbennett',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/205.png',

            description_point: 'Working hard and working smart sometimes can be two different things.',
            url_point: 'http://freelance.vioo.ru/members/3/ '
            },
                                                   {
            name: 'Elen Western',
            location_latitude: 37.474059,
            location_longitude: -122.262102,
            map_image_url: 'http://static1.squarespace.com/static/541b08ace4b03814779bda86/t/542602f3e4b0f1b39f8aee91/1411777365327/',
            name_point: 'Elen Western',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/206.png',

            description_point: 'inferiorlittlermore illsickersmaller',
            url_point: 'http://freelance.vioo.ru/members/13/ '
            },
                                                   {
            name: 'emiluzelac',
            location_latitude: 37.466059,
            location_longitude: -122.258102,
            map_image_url: 'http://s14.postimage.org/fgdr8qc35/Proenza_Schouler_Headshot.jpg',
            name_point: 'emiluzelac',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/204.png',

            description_point: 'The best preparation for good work tomorrow is to do good work today.',
            url_point: 'http://freelance.vioo.ru/members/5/ '
            },
                                                   {
            name: 'Eric Carlberg',
            location_latitude: 37.471059,
            location_longitude: -122.255102,
            map_image_url: 'https://www.twenty-twenty.co.uk/images/uploads/artists/hugh-elliot.jpg',
            name_point: 'Eric Carlberg',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/205.png',

            description_point: 'inferiorlittlermore illsickersmaller',
            url_point: 'http://freelance.vioo.ru/members/14/ '
            },
                                                   {
            name: 'gasha',
            location_latitude: 37.465059,
            location_longitude: -122.252102,
            map_image_url: 'http://www.mygardendesignblog.com/wp-content/uploads/2012/05/garden_design_birgit_aarsleff_sommer.jpg',
            name_point: 'gasha',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/206.png',

            description_point: 'The supreme accomplishment is to blur the line between work and play.',
            url_point: 'http://freelance.vioo.ru/members/15/ '
            },
                                                   {
            name: 'John',
            location_latitude: 37.470059,
            location_longitude: -122.252102,
            map_image_url: 'http://tekhne.it/crud/assets/uploads/designer/2014/a2d6b-produks.jpg',
            name_point: 'John',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/206.png',

            description_point: 'inferiorlittlermore illsickersmaller',
            url_point: 'http://freelance.vioo.ru/members/21/ '
            },
                                                   {
            name: 'lance',
            location_latitude: 37.468059,
            location_longitude: -122.262102,
            map_image_url: 'http://www.dearkgroup.com/wp-content/uploads/2013/05/foto_architetto_francesco_bilanzuolo.jpg',
            name_point: 'lance',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/204.png',

            description_point: 'It is the working man who is the happy man. It is the idle man who is the miserable man.',
            url_point: 'http://freelance.vioo.ru/members/4/ '
            },
                                                   {
            name: 'Sasha',
            location_latitude: 37.472059,
            location_longitude: -122.260102,
            map_image_url: 'http://2012.iasummit.org/headshots/Justin_Davis.png',
            name_point: 'Sasha',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/204.png',

            description_point: 'By working faithfully eight hours a day you may eventually get to be boss and work twelve hours a day.',
            url_point: 'http://freelance.vioo.ru/members/32/ '
            },
                                                   {
            name: 'Spammer',
            location_latitude: 37.474059,
            location_longitude: -122.253102,
            map_image_url: 'http://freelance.vioo.ru/wp-content/uploads/bfi_thumb/userd-mii020t1pkq4rh2il38e9z54ebodakmo1xxi77yy9s.jpg',
            name_point: 'Spammer',
            fa_icon: 'http://freelance.vioo.ru/wp-content/uploads/205.png',

            description_point: 'inferiorlittlermore illsickersmaller',
            url_point: 'http://freelance.vioo.ru/members/8/ '
            },
                            
           ]
              
           };




    function d(a){return function(b){this[a]=b}}function f(a){return function(){return this[a]}}var h; function i(a,b,c){this.extend(i,google.maps.OverlayView);this.b=a;this.a=[];this.l=[];this.V=[53,56,66,78,90];this.j=[];this.v=false;c=c||{};this.f=c.gridSize||60;this.R=c.maxZoom||null;this.j=c.styles||[];this.Q=c.imagePath||this.J;this.P=c.imageExtension||this.I;this.W=c.zoomOnClick||true;l(this);this.setMap(a);this.D=this.b.getZoom();var e=this;google.maps.event.addListener(this.b,"zoom_changed",function(){var g=e.b.mapTypes[e.b.getMapTypeId()].maxZoom,k=e.b.getZoom();if(!(k<0||k>g))if(e.D!=k){e.D= e.b.getZoom();e.m()}});google.maps.event.addListener(this.b,"bounds_changed",function(){e.i()});b&&b.length&&this.z(b,false)}h=i.prototype;h.J="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m";h.I="png";h.extend=function(a,b){return function(c){for(property in c.prototype)this.prototype[property]=c.prototype[property];return this}.apply(a,[b])};h.onAdd=function(){if(!this.v){this.v=true;m(this)}};h.O=function(){};h.draw=function(){}; function l(a){for(var b=0,c;c=a.V[b];b++)a.j.push({url:a.Q+(b+1)+"."+a.P,height:c,width:c})}h=i.prototype;h.u=f("j");h.L=f("a");h.N=f("a");h.C=function(){return this.R||this.b.mapTypes[this.b.getMapTypeId()].maxZoom};h.A=function(a,b){for(var c=0,e=a.length,g=e;g!==0;){g=parseInt(g/10,10);c++}c=Math.min(c,b);return{text:e,index:c}};h.T=d("A");h.B=f("A");h.z=function(a,b){for(var c=0,e;e=a[c];c++)n(this,e);b||this.i()}; function n(a,b){b.setVisible(false);b.setMap(null);b.q=false;b.draggable&&google.maps.event.addListener(b,"dragend",function(){b.q=false;a.m();a.i()});a.a.push(b)}h=i.prototype;h.o=function(a,b){n(this,a);b||this.i()};h.S=function(a){var b=-1;if(this.a.indexOf)b=this.a.indexOf(a);else for(var c=0,e;e=this.a[c];c++)if(e==a)b=c;if(b==-1)return false;this.a.splice(b,1);a.setVisible(false);a.setMap(null);this.m();this.i();return true};h.M=function(){return this.l.length};h.getMap=f("b");h.setMap=d("b"); h.t=f("f");h.U=d("f");function o(a,b){var c=a.getProjection(),e=new google.maps.LatLng(b.getNorthEast().lat(),b.getNorthEast().lng()),g=new google.maps.LatLng(b.getSouthWest().lat(),b.getSouthWest().lng());e=c.fromLatLngToDivPixel(e);e.x+=a.f;e.y-=a.f;g=c.fromLatLngToDivPixel(g);g.x-=a.f;g.y+=a.f;e=c.fromDivPixelToLatLng(e);c=c.fromDivPixelToLatLng(g);b.extend(e);b.extend(c);return b}i.prototype.K=function(){this.m();this.a=[]}; i.prototype.m=function(){for(var a=0,b;b=this.l[a];a++)b.remove();for(a=0;b=this.a[a];a++){b.q=false;b.setMap(null);b.setVisible(false)}this.l=[]};i.prototype.i=function(){m(this)}; function m(a){if(a.v)for(var b=o(a,new google.maps.LatLngBounds(a.b.getBounds().getSouthWest(),a.b.getBounds().getNorthEast())),c=0,e;e=a.a[c];c++){var g=false;if(!e.q&&b.contains(e.getPosition())){for(var k=0,j;j=a.l[k];k++)if(!g&&j.getCenter()&&j.s.contains(e.getPosition())){g=true;j.o(e);break}if(!g){j=new p(a);j.o(e);a.l.push(j)}}}}function p(a){this.h=a;this.b=a.getMap();this.f=a.t();this.d=null;this.a=[];this.s=null;this.k=new q(this,a.u(),a.t())} p.prototype.o=function(a){var b;a:if(this.a.indexOf)b=this.a.indexOf(a)!=-1;else{b=0;for(var c;c=this.a[b];b++)if(c==a){b=true;break a}b=false}if(b)return false;if(!this.d){this.d=a.getPosition();r(this)}if(this.a.length==0){a.setMap(this.b);a.setVisible(true)}else if(this.a.length==1){this.a[0].setMap(null);this.a[0].setVisible(false)}a.q=true;this.a.push(a);if(this.b.getZoom()>this.h.C())for(a=0;b=this.a[a];a++){b.setMap(this.b);b.setVisible(true)}else if(this.a.length<2)s(this.k);else{a=this.h.u().length; b=this.h.B()(this.a,a);this.k.setCenter(this.d);a=this.k;a.w=b;a.ba=b.text;a.X=b.index;if(a.c)a.c.innerHTML=b.text;b=Math.max(0,a.w.index-1);b=Math.min(a.j.length-1,b);b=a.j[b];a.H=b.url;a.g=b.height;a.n=b.width;a.F=b.Z;a.anchor=b.Y;a.G=b.$;this.k.show()}return true};p.prototype.getBounds=function(){r(this);return this.s};p.prototype.remove=function(){this.k.remove();delete this.a};p.prototype.getCenter=f("d");function r(a){a.s=o(a.h,new google.maps.LatLngBounds(a.d,a.d))}p.prototype.getMap=f("b"); function q(a,b,c){a.h.extend(q,google.maps.OverlayView);this.j=b;this.aa=c||0;this.p=a;this.d=null;this.b=a.getMap();this.w=this.c=null;this.r=false;this.setMap(this.b)} q.prototype.onAdd=function(){this.c=document.createElement("DIV");if(this.r){this.c.style.cssText=t(this,u(this,this.d));this.c.innerHTML=this.w.text}this.getPanes().overlayImage.appendChild(this.c);var a=this;google.maps.event.addDomListener(this.c,"click",function(){var b=a.p.h;google.maps.event.trigger(b,"clusterclick",[a.p]);if(b.W){a.b.panTo(a.p.getCenter());a.b.fitBounds(a.p.getBounds())}})}; function u(a,b){var c=a.getProjection().fromLatLngToDivPixel(b);c.x-=parseInt(a.n/2,10);c.y-=parseInt(a.g/2,10);return c}q.prototype.draw=function(){if(this.r){var a=u(this,this.d);this.c.style.top=a.y+"px";this.c.style.left=a.x+"px"}};function s(a){if(a.c)a.c.style.display="none";a.r=false}q.prototype.show=function(){if(this.c){this.c.style.cssText=t(this,u(this,this.d));this.c.style.display=""}this.r=true};q.prototype.remove=function(){this.setMap(null)}; q.prototype.onRemove=function(){if(this.c&&this.c.parentNode){s(this);this.c.parentNode.removeChild(this.c);this.c=null}};q.prototype.setCenter=d("d"); function t(a,b){var c=[];document.all?c.push('filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="'+a.H+'");'):c.push("background:url("+a.H+");");if(typeof a.e==="object"){typeof a.e[0]==="number"&&a.e[0]>0&&a.e[0]<a.g?c.push("height:"+(a.g-a.e[0])+"px; padding-top:"+a.e[0]+"px;"):c.push("height:"+a.g+"px; line-height:"+a.g+"px;");typeof a.e[1]==="number"&&a.e[1]>0&&a.e[1]<a.n?c.push("width:"+(a.n-a.e[1])+"px; padding-left:"+a.e[1]+"px;"):c.push("width:"+a.n+"px; text-align:center;")}else c.push("height:"+ a.g+"px; line-height:"+a.g+"px; width:"+a.n+"px; text-align:center;");c.push("cursor:pointer; top:"+b.y+"px; left:"+b.x+"px; color:"+(a.F?a.F:"black")+"; position:absolute; font-size:"+(a.G?a.G:11)+"px; font-family:Arial,sans-serif; font-weight:bold");return c.join("")}window.MarkerClusterer=i;i.prototype.addMarker=i.prototype.o;i.prototype.addMarkers=i.prototype.z;i.prototype.clearMarkers=i.prototype.K;i.prototype.getCalculator=i.prototype.B;i.prototype.getGridSize=i.prototype.t; i.prototype.getMap=i.prototype.getMap;i.prototype.getMarkers=i.prototype.L;i.prototype.getMaxZoom=i.prototype.C;i.prototype.getStyles=i.prototype.u;i.prototype.getTotalClusters=i.prototype.M;i.prototype.getTotalMarkers=i.prototype.N;i.prototype.redraw=i.prototype.i;i.prototype.removeMarker=i.prototype.S;i.prototype.resetViewport=i.prototype.m;i.prototype.setCalculator=i.prototype.T;i.prototype.setGridSize=i.prototype.U;i.prototype.onAdd=i.prototype.onAdd;i.prototype.draw=i.prototype.draw; i.prototype.idle=i.prototype.O;q.prototype.onAdd=q.prototype.onAdd;q.prototype.draw=q.prototype.draw;q.prototype.onRemove=q.prototype.onRemove;


(function (A) {

  if (!Array.prototype.forEach)
    A.forEach = A.forEach || function (action, that) {
      for (var i = 0, l = this.length; i < l; i++)
        if (i in this)
          action.call(that, this[i], i, this);
    };

})(Array.prototype);

var global_scrollwheel = false;
var markerClusterer = null;
var markerCLuster;
var Clusterer;


function initialize_new() {

  var bounds = new google.maps.LatLngBounds();
  var mapOptions2 = {
    zoom : parseInt(fmr_map_init_obj.zum) ,
    minZoom : 3,
    center : new google.maps.LatLng(parseFloat(fmr_map_init_obj.lat), parseFloat(fmr_map_init_obj.longu)),
    mapTypeId : google.maps.MapTypeId.ROADMAP,

    mapTypeControl : false,
    mapTypeControlOptions : {
      style : google.maps.MapTypeControlStyle.DROPDOWN_MENU,
      position : google.maps.ControlPosition.LEFT_CENTER
    },
    panControl : false,
    panControlOptions : {
      position : google.maps.ControlPosition.TOP_RIGHT
    },
    zoomControl : true,
    zoomControlOptions : {
      style : google.maps.ZoomControlStyle.LARGE,
      position : google.maps.ControlPosition.TOP_RIGHT
    },
    scaleControl : false,
    scaleControlOptions : {
      position : google.maps.ControlPosition.TOP_LEFT
    },
    streetViewControl : false,
    streetViewControlOptions : {
      position : google.maps.ControlPosition.LEFT_TOP
    },
    styles : global_map_styles,
    scrollwheel : global_scrollwheel
  };

  var
  marker;
  //console.log(mapOptions);
  mapObject = new google.maps.Map(document.getElementById('map'), mapOptions2);


  google.maps.event.addListener(mapObject, 'click', function () {
    closeInfoBox();
  });
  var markerCluster;
  for (var key in markersData) {
    markersData[key].forEach(function (item) {
      marker = new google.maps.Marker({
          position : new google.maps.LatLng(item.location_latitude, item.location_longitude),
          map : mapObject,
          icon : item.fa_icon //,
        });
      loc = new google.maps.LatLng(item.location_latitude, item.location_longitude);
      bounds.extend(loc);

      if ('undefined' === typeof markers[key])
        markers[key] = [];
      markers[key].push(marker);
      google.maps.event.addListener(marker, 'click', (function () {
          closeInfoBox();
          getInfoBox(item).open(mapObject, this);
          mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
        }));

    });
  }

 //clastern options
  var mcOptions = {
    gridSize : 10,
    maxZoom : 20,
    styles : [{
        height : 53,
        url : "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png",
        width : 53
      }, {
        height : 56,
        url : "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m2.png",
        width : 56
      }, {
        height : 66,
        url : "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m3.png",
        width : 66
      }, {
        height : 78,
        url : "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m4.png",
        width : 78
      }, {
        height : 90,
        url : "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m5.png",
        width : 90
      }
    ]

  };
    
    //new clastern grup
   Clusterer = new MarkerClusterer(mapObject, [], mcOptions);

  for (var key in markers)
    markersData[key].forEach(function (item) {
      //add  markers to Clusterer
      Clusterer.addMarkers(markers[key], true);

    });

if(fmr_map_init_obj.lat.length < 3) {    
   mapObject.fitBounds(bounds);
   mapObject.panToBounds(bounds);
    }

};
//google.maps.event.addDomListener(window, 'load', initialize_new);
function hideAllMarkers() {
  for (var key in markers)
    markers[key].forEach(function (marker) {
      marker.setMap(null);
    });
};

function toggleMarkers(category) {
    /*$("a").removeClass('activmap');
    $(category).addClass('activmap');*/
  hideAllMarkers();
  closeInfoBox();   
  if ('undefined' === typeof markers[category])
    return false;
  markers[category].forEach(function (marker) {
    marker.setMap(mapObject);
    marker.setAnimation(google.maps.Animation.DROP);

  });    
    
    //delet  Clusterer
    Clusterer.clearMarkers();
    // Clusterer add new Markers
    Clusterer.addMarkers(markers[category], true);
    // Clusterer redraw
    Clusterer.redraw()
};

function closeInfoBox() {
  jQuery('div.infoBox').remove();
};

function getInfoBox(item) {
  return new InfoBox({
    content :
    '<div class="marker_info none" id="marker_info">' +
    '<div class="info" id="info">' +
    '<img src="' + item.map_image_url + '" class="logotype" alt=""/>' +
    '<h2>' + item.name_point + '<span></span></h2>' +
    '<span>' + item.description_point + '</span>' +
    '<a href="' + item.url_point + '" class="green_btn">More info</a>' +
    '<span class="arrow"></span>' +
    '</div>' +
    '</div>',
    disableAutoPan : true,
    maxWidth : 0,
    pixelOffset : new google.maps.Size(40, -210),
    closeBoxMargin : '50px 200px',
    closeBoxURL : '',
    isHidden : false,
    pane : 'floatPane',
    enableEventPropagation : true
  });

};


     function initialize_map() {   
            loadScript("http://city1.vioo.ru/wp-content/themes/mycity/js/infobox.js", after_load);
        }

function after_load() {
            initialize_new();
                    }
                    
                    
                    function loadScript(src, callback) {
  var s,
  r,
  t;
  r = false;
  s = document.createElement('script');
  s.type = 'text/javascript';
  s.src = src;
  s.onload = s.onreadystatechange = function () {
    ////console.log( this.readyState ); //uncomment this line to see which ready states are called.
    if (!r && (!this.readyState || this.readyState == 'complete')) {
      r = true;
      callback();
    }
  };
  t = document.getElementsByTagName('script')[0];
  t.parentNode.insertBefore(s, t);

}





"use strict";
            var fmr_ajaxurl = 'http://freelance.vioo.ru/wp-admin/admin-ajax.php';
            var fmr_gpid = '1805';
            var fmr_cpage = '';
            var global_map_styles = [];
            var templateUrl = 'http://freelance.vioo.ru/wp-content/themes/frame_fl';
            var pluginsUrl = 'http://freelance.vioo.ru/wp-content/plugins';
            var fmr_tags = [{value: 'PHP'},{value: 'HTML'},{value: 'CSSf'}];