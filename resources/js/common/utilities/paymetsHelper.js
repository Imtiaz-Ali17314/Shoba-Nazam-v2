/**
 * Sorts products from cheapest to most expensive.
 * Order: Free -> Pro -> Business -> ...
 * Products with no prices are moved to the end.
 */
export const sortProductsByPrice = (products) => {
    if (!Array.isArray(products)) return [];

    return products.sort((a, b) => {
        const getMinPrice = (product) => {
            const name = (product.name || '').toLowerCase();
            if (name === 'free') return 0;
            if (!product.prices || product.prices.length === 0) return 999999;

            // Get the minimum price from active prices
            const activePrices = product.prices.filter(p => p.is_active !== false);
            const pricesToConsider = activePrices.length > 0 ? activePrices : product.prices;

            return Math.min(...pricesToConsider.map(p => parseFloat(p.price)));
        };

        const priceA = getMinPrice(a);
        const priceB = getMinPrice(b);

        if (priceA !== priceB) {
            return priceA - priceB;
        }

        // Fallback to alphabetical sorting for same price
        return (a.name || '').localeCompare(b.name || '');
    });
};
