/********

Goals for this page:

 - Extract the ID from the URL and all of the posted variables (voting results)
 - If the required variables aren't set OR an 'already voted' cookie is set - Redirect to viewpoll
 - Submit a query to the database to ++ the vote values for each voted on choice 
 - Set a cookie that the user has already voted on this poll
 - Redirect to viewpoll.php?id=pollid&display=results

********/
