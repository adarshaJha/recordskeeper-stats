from crontab import CronTab
 
my_cron = CronTab(user='enter_your_user_name')
job = my_cron.new(command='python file path')
job2 = my_cron.new(command='python file path')
job3 = my_cron.new(command='python file path')
job4 = my_cron.new(command='python file path')
job.minute.every(1)
job.minute.every(1)
job2.hour.every(1)
job2.hour.every(1)

#my_cron.remove_all()
my_cron.write()
