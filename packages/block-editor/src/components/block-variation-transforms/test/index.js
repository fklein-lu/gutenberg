/**
 * Internal dependencies
 */
import { getMatchingVariationName } from '../index';

describe( 'BlockVariationTransforms', () => {
	describe( 'getMatchingVariationName', () => {
		describe( 'should not find a match', () => {
			it( 'when no variations or attributes passed', () => {
				expect(
					getMatchingVariationName( null, { content: 'hi' } )
				).toBeUndefined();
				expect( getMatchingVariationName( {} ) ).toBeUndefined();
			} );
			it( 'when no variation matched', () => {
				const variations = [
					{ name: 'one', attributes: { level: 1 } },
					{ name: 'two', attributes: { level: 2 } },
				];
				expect(
					getMatchingVariationName( { level: 4 }, variations )
				).toBeUndefined();
			} );
			it( 'when more than one match found', () => {
				const variations = [
					{ name: 'one', attributes: { level: 1 } },
					{ name: 'two', attributes: { level: 1, content: 'hi' } },
				];
				expect(
					getMatchingVariationName(
						{ level: 1, content: 'hi', other: 'prop' },
						variations
					)
				).toBeUndefined();
			} );
			it( 'when variation is a superset of attributes', () => {
				const variations = [
					{ name: 'one', attributes: { level: 1, content: 'hi' } },
				];
				expect(
					getMatchingVariationName(
						{ level: 1, other: 'prop' },
						variations
					)
				).toBeUndefined();
			} );
		} );
		describe( 'should find a match', () => {
			it( 'when variation has one attribute', () => {
				const variations = [
					{ name: 'one', attributes: { level: 1 } },
					{ name: 'two', attributes: { level: 2 } },
				];
				expect(
					getMatchingVariationName(
						{ level: 2, content: 'hi', other: 'prop' },
						variations
					)
				).toEqual( 'two' );
			} );
			it( 'when variation has many attributes', () => {
				const variations = [
					{ name: 'one', attributes: { level: 1, content: 'hi' } },
					{ name: 'two', attributes: { level: 2 } },
				];
				expect(
					getMatchingVariationName(
						{ level: 1, content: 'hi', other: 'prop' },
						variations
					)
				).toEqual( 'one' );
			} );
		} );
	} );
} );
