select products.id as productid, categories.id as categoryid,product_translations.locale, product_translations.title, category_translations.title from product_translations
join products on product_translations.product_id = products.id
join categories on products.category_id = categories.id
join category_translations on categories.id = category_translations.category_id
