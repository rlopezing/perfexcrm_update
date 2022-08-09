select tblcvisit.*, tblcvtype.type, tblcvtake_data.date_add as take_date,
	(case when (tblcvisit.date_input is null) 
		then timestampdiff(day, tblcvisit.date_add, CURDATE()) 
        else timestampdiff(day, tblcvisit.date_add, tblcvisit.date_input) end) as day_date_input, 
	(case when (tblcvisit.date_inbank is null) 
		then (case when (tblcvisit.date_input is null) 
				then 0 else timestampdiff(day, tblcvisit.date_input, CURDATE()) end) 
        else timestampdiff(day, tblcvisit.date_input, tblcvisit.date_inbank) end) as day_date_inbank, 
	(case when (tblcvisit.date_study is null) 
		then (case when (tblcvisit.date_inbank is null) 
				then 0 else timestampdiff(day, tblcvisit.date_study, CURDATE()) end) 
        else timestampdiff(day, tblcvisit.date_inbank, tblcvisit.date_study) end) as day_date_study, 
	(case when (tblcvisit.date_approved is null) 
		then (case when (tblcvisit.date_study is null) 
				then 0 else timestampdiff(day, tblcvisit.date_study, CURDATE()) end) 
        else timestampdiff(day, tblcvisit.date_study, tblcvisit.date_approved) end) as day_date_approved, 
	(case when (tblcvisit.date_finished is null) 
		then (case when (tblcvisit.date_approved is null) 
				then 0 else timestampdiff(day, tblcvisit.date_approved, CURDATE()) end) 
        else timestampdiff(day, tblcvisit.date_approved, tblcvisit.date_finished) end) as day_date_finished, 
	(case when (tblcvisit.date_finished is null) 
		then timestampdiff(day, tblcvisit.date_add, CURDATE()) 
        else timestampdiff(day, tblcvisit.date_add, tblcvisit.date_finished) end) as days_passed 
	
from tblcvisit
	inner join tblclients on tblclients.userid = tblcvisit.client
    inner join tblcvtype on tblcvtype.id = tblcvisit.type
    inner join tblcvtake_data on tblcvtake_data.client = tblcvisit.client
where tblcvisit.id = 1 and tblcvisit.status > 1;
