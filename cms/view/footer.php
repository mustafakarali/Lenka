		<script type="text/javascript">
			// This is a check for the CKEditor class. If not defined, the paths must be checked.
			if ( typeof CKEDITOR == 'undefined' )
			{
				document.write(
					'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
					'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
					'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
					'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
					'value (line 32).' ) ;
			}
			else
			{
				// var editor = CKEDITOR.replace( 'editor1' );
				// editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );	
				// Just call CKFinder.setupCKEditor and pass the CKEditor instance as the first argument.
				// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
				CKFinder.setupCKEditor( null, '<?php echo Routes::$base; ?>') ;
			}
		</script>
		<?php 
		echo '<script>'.$setting['js_in_footer'].'</script>'; 
		?>
	</body>
</html>