const { addFilter } = wp.hooks;

wp.domReady( () => {
	wp.blocks.registerBlockStyle( 'core/group', [ 
		{
			name: 'offset',
			label: 'Offset Top',
		},
	]);

	wp.blocks.registerBlockStyle( 'core/heading', [ 
		{
			name: 'headline',
			label: 'Headline',
			isDefault: true,
		},
		{
			name: 'accent',
			label: 'Subheadline',
		}
	]);

	wp.blocks.registerBlockStyle( 'core/paragraph', [ 
		{
			name: 'body',
			label: 'Body',
			isDefault: true,
		},
		{
			name: 'lead',
			label: 'Lead Paragraph',
		}
	]);

	wp.blocks.registerBlockStyle( 'core/button', [ 
		{
			name: 'plain',
			label: 'Plain',
			isDefault: true,
		},
		{
			name: 'small',
			label: 'Small',
		},
		{
			name: 'arrow',
			label: 'Arrow',
		},
		{
			name: 'disabled',
			label: 'Disabled',
		}
	]);
	
	wp.blocks.unregisterBlockStyle(
		'core/button',
		[ 'default', 'outline', 'squared', 'fill' ]
	);
} );