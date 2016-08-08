<div id="cwp-pdf-editor">
	
	 <div class="cwp-pdf-editor-field cwp-pdf-preview">
        	<a href="<?php echo $post_link;?>?pdf=preview" target="_blank">Preview PDF</a>
        </div>
		<fieldset class="cwp-pdf-update-url">
        	<div class="cwp-pdf-editor-field cwp-pdf-update">
                <a href="<?php echo $post_link;?>?pdf=save">Update PDF</a>
            </div>
            <div class="cwp-pdf-editor-field cwp-pdf-url">
                <input type="text" name="<?php echo $this->meta_key;?>" value="<?php echo $pdf_url;?>" placeholder="PDF Download URL" />
            </div>
        </fieldset> 
        <div class="cwp-share-link">
    	<strong>PDF Share Link: <a href="<?php echo $post_link;?>?pdf=preview" target="_blank"><?php echo $post_link;?>?pdf=true</a></strong>
    </div>  
</div>