USE rakan_teknikal_ftmk;

-- Safe upgrade file only. It does not drop/rename the existing database or tables.
-- Run this after your original sqltable.txt if your existing table is missing these columns.

ALTER TABLE students
  MODIFY status_category ENUM('B40','M40','T20') NOT NULL DEFAULT 'B40',
  MODIFY merit_score TINYINT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE jobs
  MODIFY job_date DATE NOT NULL,
  MODIFY allowance VARCHAR(50) NOT NULL,
  MODIFY allowance_amount DECIMAL(10,2) DEFAULT 0.00;

ALTER TABLE applications
  MODIFY status ENUM('Pending','Approved','Rejected','Completed') NOT NULL DEFAULT 'Pending',
  MODIFY paid_amount DECIMAL(10,2) DEFAULT NULL;

-- Optional starter jobs for demo / presentation. Insert only if table is empty.
INSERT INTO jobs (title, location, job_date, allowance, allowance_amount, todo, slots, is_active)
SELECT * FROM (
  SELECT 'Penjaga Kunci Makmal','Makmal Komputer FTMK',DATE_ADD(CURDATE(), INTERVAL 3 DAY),'RM 5/hour',5.00,'Jaga kunci makmal dan pastikan peralatan cukup sebelum/selepas kelas.',1,1
  UNION ALL SELECT 'Pembantu Bengkel Komputer','Bilik Seminar FTMK',DATE_ADD(CURDATE(), INTERVAL 7 DAY),'RM 30 one off',30.00,'Bantu setup komputer, projector dan susun peserta bengkel.',1,1
  UNION ALL SELECT 'Teknikal PA System Event','Dewan FTMK',DATE_ADD(CURDATE(), INTERVAL 14 DAY),'RM 30 one off',30.00,'Sediakan mic, speaker dan semak audio sepanjang event.',1,1
) demo
WHERE NOT EXISTS (SELECT 1 FROM jobs LIMIT 1);
