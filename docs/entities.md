## Post:
* ID (int) - id - Unique Post ID
* Title (varchar) - title - Post title
* Alias (varchar) - alias - URL alias (e.g. ./blog/{category}/{alias})
* Time (int) - time - UNIX timestamp of post
* Last edited time (int) - edit_time - UNIX timestamp of last modification
* Status (int) - status - Approved/unapproved state of the post
* Locked (bool) - locked - Locked/unlocked state of the post
* Poster ID (int) - poster_id - User ID of the poster
* Category ID (int) - category_id - ID of the category
* Comment count (int) - comment_count - Number of comments on the blog post
* Content (text) - content - Actual post content
* BBCode UID (varchar) - bbcode_uid - BBCode UID
* BBCode Bitfield (varchar) - bbcode_bitfield - BBCode Bitfield

## Comment
* ID (int) - id - Unique comment ID
* Post ID (int) - post_id - Post ID to which this comment is related
* Content (text) - content - Actual content of the comment
* Time (int) - time - UNIX timestamp of comment
* Last edited time (int) - edit_time UNIX timestamp of last modification
* Poster ID (int) - poster_id - ID of the comment poster
* Status (int) - status - Approved/unapproved state of the comment
* BBCode UID (varchar) - bbcode_uid - BBCode UID
* BBCode Bitfield (varchar) - bbcode_bitfield - BBCode Bitfield

## Tag
* Tag ID (int) - id - ID of the tag
* Title (varchar) - title - Title of the tag
* Alias (varchar) - alias - URL Alias of the title
Tag Name

## Category
* Category ID (int) - id - ID of the category
* Title (varchar) - title - Title of the category
* Alias (varchar) - alias - Alias of the category (e.g. ./blog/{alias})
* Post count (int) - post_count - Number of posts in the category
Name

## Post to Tag
* ID (int) - id - Unique relation ID
* Tag ID (int) - tag_id - ID of the tag
* Post ID (int) - post_id - ID of the post
