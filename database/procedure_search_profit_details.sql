DELIMITER //
CREATE OR REPLACE PROCEDURE search_profit_details(
	IN sdate DATE,
	IN edate DATE
)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
	SELECT p.date_field, DATE_FORMAT(p.date_field,'%d/%m') date_x, ifnull(r.rvamt,0) rvamt, ifnull(b.bfamt,0) bfamt, ifnull(e.expamt,0) expamt
	FROM
	(
	    SELECT
	        MAKEDATE(YEAR(sdate),1) +
	        INTERVAL (MONTH(sdate)-1) MONTH +
	        INTERVAL daynum DAY date_field
	    FROM
	    (
	        SELECT t*10+u daynum
	        FROM
	            (SELECT 0 t UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6) A,
	            (SELECT 0 u UNION SELECT 1 UNION SELECT 2 UNION SELECT 3
	            UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
	            UNION SELECT 8 UNION SELECT 9) B
	        ORDER BY daynum
	    ) AA
	) p LEFT OUTER JOIN 
		(
			SELECT rvndate, SUM(rvnamt) rvamt
			FROM revenue 
			WHERE rvndate BETWEEN sdate AND edate
			AND rvncd != '2'
			GROUP BY rvndate ) r ON p.date_field=r.rvndate
		LEFT OUTER JOIN 
		(
			SELECT bfdate, SUM(bfqty) bfamt
			FROM buffet 
			WHERE bfdate BETWEEN sdate AND edate
			AND bftype = '7'
			GROUP BY bfdate ) b ON p.date_field=b.bfdate 
		LEFT OUTER JOIN 
		(
			SELECT expdate, SUM(expamt) expamt
			FROM expenses 
			WHERE expdate BETWEEN sdate AND edate
			GROUP BY expdate ) e ON p.date_field=e.expdate
	WHERE date_field BETWEEN sdate AND edate
	ORDER BY date_field;

END //
DELIMITER ;