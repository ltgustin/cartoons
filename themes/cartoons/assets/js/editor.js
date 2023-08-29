// my-plugin.js
wp.domReady( () => {
    wp.blocks.unregisterBlockType( 'core/verse' );
    // wp.blocks.unregisterBlockType( 'core/cover' );
    wp.blocks.unregisterBlockType( 'core/pullquote' );
    wp.blocks.unregisterBlockType( 'core/more' );
    wp.blocks.unregisterBlockType( 'core/nextpage' );
    wp.blocks.unregisterBlockType( 'core/archives' );
    wp.blocks.unregisterBlockType( 'core/categories' );
    wp.blocks.unregisterBlockType( 'core/latest-comments' );
    wp.blocks.unregisterBlockType( 'core/latest-posts' );
    wp.blocks.unregisterBlockType( 'core/calendar' );
    wp.blocks.unregisterBlockType( 'core/rss' );
    wp.blocks.unregisterBlockType( 'core/search' );
    wp.blocks.unregisterBlockType( 'core/tag-cloud' );

    wp.blocks.unregisterBlockStyle(
        'core/button',
        [ 'default', 'outline', 'squared', 'fill' ]
    );

    wp.blocks.registerBlockStyle(
        'core/button',
        [
            {
                name: 'default',
                label: 'Default',
                isDefault: true,
            },
            {
                name: 'full',
                label: 'Full Width',
            }
        ]
    );
});