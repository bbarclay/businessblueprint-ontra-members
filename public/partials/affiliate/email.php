<div style="display:none;" class="share-link"><span class="clipboard" id="clipboard">[ontralink]</span><button class="btn-copy" id="copy-btn" onclick="copyToClipboard('#clipboard')">Copy</button></div>
<section class="more-info">
  <div class="container">
       <h3 class="heading text-center">Share your affiliate link to your email list</h3>
       <p class="text-center">Here are some templates that you can use to help you promote 52 Ways and earn valuable rewards. All you need to do is cut and paste the text (remember to put in your affiliate link) and add it to your email client. Feel free to make any changes or modification to suit your personal and style.  From there you can have as many contacts as you like.</p>

      <p class="text-center">If you’re not sending thru a professional CRM then it would be best to send email one at a time to ensure they get through to their intended destination. Should you require anything else custom then please let us know.</p>
       <div class="share-text">
          <div class="share-choose" id="choose-option">
               <ul>
                   <li class="facebook-btn active tabemaillinks"  onclick="openEmail(event, 'tabEmail1')"><span>Option 1</span></li>
                   <li class="google-btn tabemaillinks" onclick="openEmail(event, 'tabEmail2')"><span>Option 2</span></li>
                   <li class="linkedin-btn tabemaillinks" onclick="openEmail(event, 'tabEmail3')"><span>Option 3</span></li>
                   <li class="twitter-btn tabemaillinks" onclick="openEmail(event, 'tabEmail4')"><span>Option 4</span></li>
               </ul>
           </div>
           <div class="share-info">
                <div class="email-text active tabemail" id="tabEmail1" style="display:block;">
                     <div class="inner-email">
                      <div class="header">New Message</div>
                      <div class="subject to"> <p><span>To : </span> </p></div>
                      <div class="subject"> <p><span>Subject :</span> You Should Join Me At This Free 1-Day Business Workshop</p></div>
                      <div class="message"><p>Hey,</p>
                      <p>I just registered to attend this free 1-Day Business Workshop and thought you would get value out of it too and should attend with me.</p>
                      <p>It’s being presented by Dale Beaumont, Founder of Business Blueprint and BRiN, who has helped over 20,000 business owners simplify and grow their business.</p>
                      <p>Here’s a link to the website with all of the details…</p>
                      <p class="link"><a href="<?php echo $member_aff_link ?>"><?php echo $member_aff_link ?></a></p>
                      <p>It looks like they're going to be covering some awesome content and the day will be content and value packed. I can't believe they give this information away to business owners for free.</p>
                     <p>Anyway, check it out and register if you want to come...</p>
                     <p>Talk soon,</p>
                     <p>[Your Name]</p> </div></div>
                    
               </div>
                <div class="facebook-text tabemail" id="tabEmail2">
                  <div class="inner-email">
                      <div class="header">New Message</div>
                      <div class="subject to"> <p><span>To : </span> </p></div>
                      <div class="subject"> <p><span>Subject :</span> Do you want to join me for an intensive day of learning?</p></div>
                      <div class="message"><p>Hey,</p>
                      <p>Have you heard about the free 1-day business workshop by Dale Beaumont?</p>
                      <p>It’s called 52 Ways because he teaches you 52 different strategies to help you boost the profits of your business. Dale is the Founder of Business Blueprint and BRiN, who has helped over 20,000 business owners simplify and grow their business.</p>
                      <p>Sounds exciting, right?</p>
                      <p>Here’s a link to the website with all of the details…</p>
                      <p class="link"><a href="<?php echo $member_aff_link ?>"><?php echo $member_aff_link ?></a></p>
                      <p>I was so excited about the workshop that I’ve already registered and hope you can come along to join me for an intensive day of learning.</p>
                      <p>Talk soon,</p>
                      <p>[Your Name]</p> </div></div>
     
         </div>
         <div class="facebook-text tabemail" id="tabEmail3">
                  <div class="inner-email">
                      <div class="header">New Message</div>
                      <div class="subject to"> <p><span>To : </span> </p></div>
                      <div class="subject"> <p><span>Subject :</span>  I’m Excited For This Free 1-day business workshop</p></div>
                      <div class="message"><p>Hey,</p>
                      <p>I heard a lot of great things about 52 Ways, a 1-Day Business Workshop by Dale Beaumont. I was so curious, I actually just registered and wanted to invite you to come along.</p>
                      <p>Dale is the Founder of Business Blueprint and BRiN, who has helped over 20,000 business owners simplify and grow their business. At the workshop he’ll teach 52 different strategies to help grow anyone’s business.  </p>
                      <p>Here’s a link to the website with all of the details…</p>
                      <p class="link"><a href="<?php echo $member_aff_link ?>"><?php echo $member_aff_link ?></a></p>
                      <p>Can you believe that Dale will be giving away these strategies for free? I’m sure we’ll get a lot of value from this workshop so let’s check it out together.</p>

                     <p>Talk soon,</p>
                     <p>[Your Name]</p> </div></div>
   
         </div>
         <div class="facebook-text tabemail" id="tabEmail4">
                  <div class="inner-email">
                      <div class="header">New Message</div>
                      <div class="subject to"> <p><span>To : </span> </p></div>
                      <div class="subject"> <p><span>Subject :</span>  I just registered for this workshop, you should, too! </p></div>
                      <div class="message"><p>Hey,</p>
                      <p>I recently discovered this free 1-Day Business Workshop, 52 Ways, which is presented by Dale Beaumont. I thought it was worth checking out so I registered to see what it’s about.</p>
                      <p>Dale is the Founder of Business Blueprint and BRiN, who has helped over 20,000 business owners simplify and grow their business. His workshop is called 52 Ways because of the 52 different strategies that he teaches in just one day.</p>
                      <p>Here’s a link to the website with all of the details…</p>
                      <p class="link"><a href="<?php echo $member_aff_link ?>"><?php echo $member_aff_link ?></a></p>
            
                     <p>Do you also want to check it out? I hope you register so we can go together. </p>
                     <p>Talk soon,</p>
                     <p>[Your Name]</p> </div></div>
    
         </div>


           </div>
            
       </div>
  </div>
</section>
<script>
    function openEmail(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabemail");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tabemaillinks");
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
