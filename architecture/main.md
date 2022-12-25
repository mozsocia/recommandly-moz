
-------
### option table data

- `all_cattegoris_ids` :( [created_at,data=>[id] ] :: serialized)
- `last_completed_cat_id` : (id)
- `running_cat_completed_post_ids` :(array[id] :: serialized) (with running cat id)

-------
### termmeta table data
- `all_posts_for_that_term` :( [created_at,data=>[..] ] :: serialized)


-------
### algorithm

- get `all_cattegoris_ids`  
- check `last_completed_cat_id` find running `cat_id`
- using running `cat_id` get `all_posts_for_that_term` as `all_cat_posts` from termmeta table
- take one `post_id` from `all_cat_posts` check it in `running_cat_completed_post_ids` , if not present go for this-post with similar-post
- before making the api call with this-post and similar-post data ,check the recommandly table that if it is there 