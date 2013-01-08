<h1>Method not found</h1>

<p>
	PHP-Simple-Framework was unable to execute the method  on this controller. Please provide a method following format:  
</p>

<p>
	For a URL of http://www.example.com/foo/bar, you will need the following code inserted into <em>/app/controller/foo.class.php</em>:<br /><br />
  
  <code>&lt;?php<br /><br />
  Controller_Foo extends Controller {<br /><br />
  &nbsp;&nbsp;public function __bar() {<br /><br />
  &nbsp;&nbsp;&nbsp;&nbsp;$this->view();<br /><br />
  &nbsp;&nbsp;}<br /><br />
  }<br /><br />
  ?&gt;  
  </code> 

</p>
  