<?php
 
class BbHelper extends AppHelper
{
    private $bb_tags = array(
		'#\[quote\](.*)\[/quote\]#sU',
		'#\[quote=(.*)\](.*)\[/quote\]#sU',
        '#\[h1\](.*)\[/h1\]#U',
        '#\[b\](.*)\[/b\]#U',
        '#\[i\](.*)\[/i\]#U',
        '#\[u\](.*)\[/u\]#U',
        '#\[url\](.*)\[/url\]#U',
        '#\[url=(.*)\](.*)\[/url\]#U',
        '#\[ul\](.*)\[/ul\]#sU',
        '#\[li\](.*)\[/li\]#sU',
		'#\[img\](.*)\[/img\]#sU',
    );
 
    private $bb_replacements = array(
		'<div class="quote">\1</div>',
		'<div class="quote">Posted by: <strong>\1</strong> <br /><br />\2</div>',
        '<h1>\1</h1>',
        '<b>\1</b>',
        '<i>\1</i>',
        '<u>\1</u>',
        '<a href="\1">\1</a>',
        '<a href="\1">\2</a>',
        '<ul>\1</ul>',
        '<li>\1</li>',
		'<br /><a href="\1"><img src="\1" class="forum_image"></img></a><br />',
    );
 
    public function parse($text)
    {
        $text = str_replace("\r", '', $text);
        while (strpos($text, "\n\n\n") !== false) $text = str_replace("\n\n\n", "\n\n", $text);
 
        $text = strip_tags($text);
 
        $text = str_replace('<', '<', $text);
        $text = str_replace('>', '>', $text);
		
		while($text != preg_replace($this->bb_tags, $this->bb_replacements, $text)) { 
			$text = preg_replace($this->bb_tags, $this->bb_replacements, $text);
		} 
		
        return $text;
    }
}
?>