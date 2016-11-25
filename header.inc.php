<header>
  <a href="/"><img src="/images/logo.png" id="logo"><span id="site-text"> Plenty<span id="bcolor">of</span>words</span></a>
  <span id="toggle" onClick="headerToggle('show')"><span></span><span></span><span></span></span>
  <span id="close-toggle" onClick="headerToggle('hide')"></span>
  <div id="option">
      <a href="/">Home</a>
      <a href="/category/startup-advice">Startup Advice</a>
      <a href="/category/technology">Technology</a>
      <a href="/category/healthcare">HealthCare</a>
      <a href="/category/books">Books</a>
      <a href="/category/quotes">Quotes</a>
 </div>
  <span id="search-icon"><img src="/images/search.png" alt="search-icon" id="search-img" onClick="searchVis()"><span id="search-close" onClick="searchHide()">&times;</span></span>
 <div id="search-div">
 	<input type="text" name="search_textbox" id="search-textbox" onKeyUp="searchData()">
    <div id="search-result"></div>
 </div>
</header>