<section class="more-info">
  <div class="container">
     <div class="share-text">
           <div class="share-choose">
               <ul>
                   <li class="facebook-btn active tablink-share"  onclick="openShare(event, 'tab-f')"><i class="fa fa-facebook"></i><span>Facebook</span></li>
                   <li class="google-btn tablink-share" onclick="openShare(event, 'tab-g')"><i class="fa fa-google" ></i><span>Google</span></li>
                   <li class="linkedin-btn tablink-share" onclick="openShare(event, 'tab-l')"><i class="fa fa-linkedin"></i><span>LinkedIn</span></li>
                   <li class="twitter-btn tablink-share" onclick="openShare(event, 'tab-tw')"><i class="fa fa-twitter"></i><span>Twitter</span></li>
               </ul>
           </div> 
           <div class="share-info">
               <div class="facebook-text  active tabshare" id="tab-f" style="display:block;">
                     <div class="s-content"><p>I've just registered for this brand new 1-day workshop called 52 Ways. If you're a business owner and are serious about taking your business to the next level, then you simply must attend this FREE business workshop. Who wants to come along with me?</p> <p><a href="<?php echo $member_aff_link ?>" target="_blank">Click here to claim your free ticket now</a></p></div>
                    <div class="share-col"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $member_aff_link ?>" class="btn-share btn" target="_blank">Click to Share</a></div>
               </div>
               <div class="google-text tabshare" id="tab-g">
                      <div class="s-content"><p>I've just registered for this brand new 1-day workshop called 52 Ways. If you're a business owner and are serious about taking your business to the next level, then you simply must attend this FREE business workshop. Who wants to come along with me?</p> <p><a href="<?php echo $member_aff_link ?>" target="_blank">Click here to claim your free ticket now</a></p></div>
                    <div class="share-col"><a href="https://plus.google.com/share?url=<?php echo $member_aff_link ?>" class="btn-share btn" target="_blank">Click to Share</a></div>
               </div>
               <div class="linkedin-text tabshare" id="tab-l">
                      <div class="s-content"><p>I've just registered for this brand new 1-day workshop called 52 Ways. If you're a business owner and are serious about taking your business to the next level, then you simply must attend this FREE business workshop. Who wants to come along with me?</p> <p><a href="<?php echo $member_aff_link ?>" target="_blank">Click here to claim your free ticket now</a></p></div>
                    <div class="share-col"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $member_aff_link ?>" class="btn-share btn" target="_blank">Click to Share</a></div>
               </div>
                <div class="twitter-text  tabshare" id="tab-tw">
                     <div class="s-content">Check out this brand new 1-Day Business Workshop... <a href="<?php echo $member_aff_link ?>" target="_blank">Click here to claim your free ticket now</a></div>
                    <div class="share-col"><a href="https://twitter.com/home?status=Check%20out%20this%20brand%20new%201-Day%20Business%20Workshop...%20%20<?php echo $member_aff_link ?>%20" class="btn-share btn" target="_blank">Click to Share</a></div>
               </div>
           </div>
       </div>
  </div>
</section>
<script>
    function openShare(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabshare");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablink-share");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
   }
   jQuery('.primary-btn').on('click', function(e){ e.preventDefault; var id = jQuery(this).attr('id'); jQuery('#embed-' + id ).toggleClass('show');
   });
  </script>