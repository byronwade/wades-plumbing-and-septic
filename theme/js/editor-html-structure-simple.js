/**
 * Simplified HTML Structure Checker for WordPress Block Editor
 */
jQuery(document).ready(function($) {
    // Wait for WordPress to be fully loaded
    setTimeout(function() {
        if (typeof wp === 'undefined' || !wp.plugins || !wp.editPost || !wp.data) {
            return;
        }
        
        // Function to check HTML content for issues
        function checkContent() {
            try {
                // Get the current post content
                var content = wp.data.select('core/editor').getEditedPostContent();
                var issues = [];
                
                // Check for empty paragraphs
                if (content.includes('<p></p>') || content.includes('<p>&nbsp;</p>')) {
                    issues.push({
                        type: 'warning',
                        message: 'Empty paragraphs detected. Consider removing them for better HTML structure.'
                    });
                }
                
                // Check for duplicate H1 tags
                var h1Count = (content.match(/<h1/g) || []).length;
                if (h1Count > 1) {
                    issues.push({
                        type: 'error',
                        message: 'Multiple H1 headings detected. A page should have only one H1 for proper SEO.'
                    });
                }
                
                // Check for images without alt text
                if (content.includes('alt=""') || content.match(/<img(?![^>]*alt=)[^>]*>/g)) {
                    issues.push({
                        type: 'error',
                        message: 'Images without alt text detected. Add descriptive alt text for accessibility and SEO.'
                    });
                }
                
                return issues;
            } catch (e) {
                console.error('Error checking HTML structure:', e);
                return [];
            }
        }
        
        // Register block styles
        if (wp.blocks && typeof wp.blocks.registerBlockStyle === 'function') {
            // Add custom style for paragraph blocks
            wp.blocks.registerBlockStyle('core/paragraph', {
                name: 'semantic-paragraph',
                label: 'Semantic Paragraph'
            });
            
            // Add custom style for heading blocks
            wp.blocks.registerBlockStyle('core/heading', {
                name: 'semantic-heading',
                label: 'Semantic Heading'
            });
            
            // Add custom style for image blocks
            wp.blocks.registerBlockStyle('core/image', {
                name: 'semantic-image',
                label: 'Accessible Image'
            });
        }
        
        // Function to display HTML structure warnings in the publish panel
        var hasAddedIssuesPanel = false;
        var checkAndDisplayIssues = function() {
            var issues = checkContent();
            
            // If we have issues and the pre-publish panel is open
            if (issues.length > 0) {
                var  = $('.editor-post-publish-panel__prepublish');
                
                if (.length && !hasAddedIssuesPanel) {
                    // Create our own panel
                    var  = $('<div class="wades-html-structure-checker components-panel__body"><h2 class="components-panel__body-title">HTML Structure Issues</h2><div class="wades-html-checker-content"></div></div>');
                    var  = .find('.wades-html-checker-content');
                    
                    // Add each issue
                    $.each(issues, function(i, issue) {
                        var  = $('<div class="components-notice is-' + issue.type + '"><div class="components-notice__content">' + issue.message + '</div></div>');
                        .append();
                    });
                    
                    // Add message about importance
                    .append('<p>Having clean HTML structure is important for SEO and accessibility.</p>');
                    
                    // Add to pre-publish panel
                    .append();
                    hasAddedIssuesPanel = true;
                }
            }
        };
        
        // Check for changes in the editor content
        var contentObserver = setInterval(function() {
            if ($('.editor-post-publish-panel').is(':visible')) {
                checkAndDisplayIssues();
            } else {
                hasAddedIssuesPanel = false;
            }
        }, 1000);
        
        // Clean up when page is unloaded
        $(window).on('unload', function() {
            clearInterval(contentObserver);
        });
    }, 1000);
});