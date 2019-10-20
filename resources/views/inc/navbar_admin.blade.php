<div class="sidenav">


    
    
    @if( Auth::user()->hasAnyRole(['admin','editor']))
      @if( Auth::user()->hasrole('admin') )
          <a  href="{{asset('admin/users')}}">{{ __('Použivatelia') }}</a>

          <a  href="{{asset('admin/categories')}}">{{ __('Kategórie') }}</a>

          <a  href="{{asset('admin/menu')}}">{{ __('Menu') }}</a>

          <a  href="{{asset('admin/comments')}}">{{ __('Komentáre') }}</a>

          <a  href="{{asset('admin/selectedarticles')}}">{{ __('Vybrané články') }}</a>
          
          <a  href="{{asset('admin/components')}}">{{ __('Komponenty') }}</a>

          <a  href="{{asset('admin/pages')}}">{{ __('Stránky') }}</a>

          <a  href="{{asset('admin/options')}}">{{ __('Všeobecné nastavenia') }}</a>
          
          <a  href="{{asset('admin/newsletter')}}">{{ __('Newsletter') }}</a>

          <a  href="{{asset('sitemap')}}" target="_blank">{{ __('SiteMap') }}</a>
        @endif
      <a href="{{asset('admin/articles')}}">{{ __('Články') }}</a>
    @endif

    <span style="position:fixed; bottom: 5px;">
      
    <a  href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
       <i class="fas fa-sign-out-alt"></i> {{ __('ODHLÁSENIE') }}
    </a>
                    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    </span>
  <!-- DROP DOWN MENU
      <button class="dropdown-btn">Dropdown 
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#">Link 1</a>
    <a href="#">Link 2</a>
    <a href="#">Link 3</a>
  </div>
  -->
</div>

<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}
</script>