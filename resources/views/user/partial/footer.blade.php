    <!-- Start footer section -->
    <footer class="footer footer__section">
        <div class="dashboard__footer--inner text-center">
            <p class="copyright__content mb-0">Copyright © {{ date('Y') }} Powered By <span>Dohmayn</span>. Designed with  by <a class="copyright__content--link" target="_blank" href="#">Hamuj</a>  All Rights Reserved.</p>
        </div>
    </footer>
    <!-- End footer section -->

 <!-- Scroll top bar --> 
 <button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round"  stroke-width="48" d="M112 244l144-144 144 144M256 120v292"/></svg></button>
     
 <!-- All Script JS Plugins here  -->
 <script src="{{ asset('assets/admin/js/vendor/popper.js')}}" defer="defer"></script>
 <script src="{{ asset('assets/admin/js/vendor/bootstrap.min.js')}}" defer="defer"></script>
 <script src="{{ asset('assets/admin/js/plugins/swiper-bundle.min.js')}}"></script>
 <script src="{{ asset('assets/admin/js/plugins/glightbox.min.js')}}"></script>
  
  <!-- Customscript js -->   
  <script src="{{ asset('assets/admin/js/script.js')}}"></script>

  <!-- Dark to light js -->
  <script>
      // On page load or when changing themes, best to add inline in `head` to avoid FOUC
      if (localStorage.getItem("theme-color") === "dark" || (!("theme-color" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
      document.getElementById("light__to--dark")?.classList.add("dark--version");
      } 
      if (localStorage.getItem("theme-color") === "light") {
      document.getElementById("light__to--dark")?.classList.remove("dark--version");
      } 
  </script>
  <!-- Chart JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Customscript js -->
  <script src="{{ asset('assets/admin/js/chart-activation.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    function toggleHideBalance(el) { 
        fetch('{{ route("user.toggle.hide.balance") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ hide_balance: el.checked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // toastr.success('Wallet balance visibility updated.', 'Success');
                setTimeout(() => {
                    location.reload(); 
                }, 1500);
                location.reload(); 
            } else {
                alert('Something went wrong!');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function copyReferralLink() {
        const referralLink = document.querySelector('.referral_code').innerText;
        navigator.clipboard.writeText(referralLink).then(() => {
            const message = document.createElement('span');
            message.className = 'copy-success';
            message.innerText = 'Referral link copied!';
            
            const referralContainer = document.querySelector('.referral-code');
            referralContainer.appendChild(message);

            // Remove the message after 3 seconds
            setTimeout(() => {
                referralContainer.removeChild(message);
            }, 3000);
        }).catch(() => {
            const message = document.createElement('span');
            message.className = 'copy-fail';
            message.innerText = 'Failed to copy referral link.';
            
            const referralContainer = document.querySelector('.referral-code');
            referralContainer.appendChild(message);

            // Remove the message after 3 seconds
            setTimeout(() => {
                referralContainer.removeChild(message);
            }, 3000);
        });
    }
    
</script>