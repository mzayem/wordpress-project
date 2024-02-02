( function( api ) {

	// Extends our custom "gaming-lite" section.
	api.sectionConstructor['gaming-lite'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );