Place category image files here before running a bulk CSV import.

Reference the exact filename (e.g. `skincare.jpg`) in the `image` column of your
CSV. During import, matching files are copied into `storage/app/public/categories/`
and the category's `image` field is set to the new stored path.

If the `image` column already contains a path that exists in `storage/app/public/`
(e.g. re-exporting and re-importing the same CSV), it is left unchanged — no file
needs to be placed here for that row.
