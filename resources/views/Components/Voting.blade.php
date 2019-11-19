<style>
/* The question */
.question {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.question input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.question:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.question input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.question input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.question .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>


<section id="about-us" style="background: aliceblue">
<form action="{{asset('voting')}}" onsubmit="return validateForm()">
  <table class="table" style="width:50%; margin: auto; text-align: center; border: 1px solid;max-width:400px;background: white ">
  <thead class="thead-dark">
    <tr>
      <th scope="col">{{$components_content['voting'][0]->question}}
      @if($components_content['voting'][0]->description)
      <br>
      <small>{{$components_content['voting'][0]->description}}</small>
      @endif
      </th>
    </tr>
  </thead>
  <tbody>
  @if($components_content['voting']['options'])
    @foreach($components_content['voting']['options'] as $option)
    <tr>
        <th scope="row" style="border: 1px solid">
            <label class="question" style="margin:auto">
                <input type="radio" value="{{$option->id}}" name="option">
                <span class="checkmark"></span>
                {{$option->value}}
            </label>
        </th>
        </tr>
        @endforeach
    @endif
  </tbody>
</table>
<div style="text-align: center;margin-top:10px">
<input type="submit" value="Hlasuj" class="search-submit" style="background-color: #454d55">
</div>
<input type="hidden" id="question" name="question" value="{{$components_content['voting'][0]->id}}">
</form>
</section>

<script>
function validateForm() {
  var x = $("input[name=option]:checked").val()
  if (!x) {
    alert("Naprv zvolte možnosť");
    return false;
  }
}
</script>