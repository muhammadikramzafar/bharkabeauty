Place product image files here before running a bulk CSV import.

Reference the main image's filename in the `image` column, and any extra
gallery images in `additional_images`, separated by `|`
(e.g. `back.jpg|swatch.jpg`). During import, matching files are copied into
`storage/app/public/products/` and the product's `images` field is updated
with the new stored paths (main image first).

If `image` or an entry in `additional_images` already contains a path that
exists in `storage/app/public/` (e.g. re-exporting and re-importing the same
CSV), it is left unchanged — no file needs to be placed here for that entry.
