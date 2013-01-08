<h1>Controller not found</h1>

<p>
	PHP-Simple-Framework was unable to load the Controller for this app. Please provide a controller in the following format:  
</p>

<p>
	For a URL of http://www.example.com/foo, you will need a controller located at <em>/app/controller/foo.class.php</em>:<br /><br />
  
  <code>&lt;?php<br /><br />
  Controller_Foo extends Controller {<br /><br />
  &nbsp;&nbsp;public function __index() {<br /><br />
  &nbsp;&nbsp;&nbsp;&nbsp;$this->view();<br /><br />
  &nbsp;&nbsp;}<br /><br />
  }<br /><br />
  ?&gt;  
  </code> 

</p>
  