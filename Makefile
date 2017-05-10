.PHONY: inst

inst:
	#ssh -t ledyba.org sudo -u www-data mkdir -p /opt/www/gehime/wp/wp-content/plugins/qpost
	scp -r * ledyba.org:/opt/www/gehime/wp/wp-content/plugins/qpost
