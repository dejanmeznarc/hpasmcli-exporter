# HELP hpe_temp_celsius Current temp in celsius 
# TYPE hpe_temp_celsius gauge
# HELP hpe_temp_threshold_celsius Threshold for warning
# TYPE hpe_temp_threshold_celsius gauge
# HELP hpe_fan_present Return 1 if fan is plugged in
# TYPE hpe_fan_present gauge
# HELP hpe_fan_redundant Return 1 if fan is redundan
# TYPE hpe_fan_redundant gauge
# HELP hpe_fan_hotplug Return 1 if fan is hotpluggalbe
# TYPE hpe_fan_hotplug gauge
# HELP hpe_fan_speed Return descriptive speed (in words)
# TYPE hpe_fan_speed gauge
# HELP hpe_fan_speed_percent Return speed in percent (0..1)
# TYPE hpe_fan_speed_percent gauge
# HELP hpe_fan_partner Return fan partner number (cpu slot)
# TYPE hpe_fan_partner gauge
# HELP hpe_power_meter Return power in watts
# TYPE hpe_power_meter gauge
# HELP hpe_psu_present Return if PSU is present
# TYPE hpe_psu_present gauge
# HELP hpe_psu_redundant Return if PSU is redundant
# TYPE hpe_psu_redundant gauge
# HELP hpe_psu_condition Return descriptive PSU condition
# TYPE hpe_psu_condition gauge
# HELP hpe_psu_hotplug Return 1 if PSU is hotpluggable
# TYPE hpe_psu_hotplug gauge
# HELP hpe_psu_power Return PSU power in watts
# TYPE hpe_psu_power gauge