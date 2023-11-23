import matplotlib.pyplot as plt
from datetime import datetime
from matplotlib import dates as mdates
from collections import defaultdict
import networkx as nx

# Function to filter logs by username
def export_file(string):
    if "mborsos" in string:
        return string

# Function to parse relevant information from access logs
def info_parser_IpDate(data_list):
    parsed_data = {}
    if "/~mborsos" in data_list[6]:
        parsed_data["IP"] = data_list[0]
        date_string = data_list[3].replace("[", "")
        parsed_data["Date"] = date_string
    return parsed_data

# Function to parse browser information from user agent string
# https://developer.mozilla.org/en-US/docs/Web/HTTP/Browser_detection_using_the_user_agent for reference 
def broswer_parsing(string):
    if "/~mborsos" in string:
        if "Chrome/" in string and "Chromium/" not in string:
            return "Chrome"
        elif "Safari/" in string and ("Chrome/" not in string or "Chromium/" not in string):
            return "Safari"
        else:
            return "Other browser than Chrome/Safari"
    else:
        return "Unknown"

# Function to parse date from string
def date_parser(string):
    aux = string.replace("[", "").split(" ")
    if len(aux) >= 2:
        return aux[0], aux[1]
    else:
        # Handle the case where the split list doesn't have enough elements
        return None, None

# Function to process access logs and return a list of dictionaries
def process_access_logs(access_log_path):
    dict_list = []
    with open(access_log_path, "r") as access_log:
        for log in access_log:
            result = info_parser_IpDate(log.split(" "))
            if result != {}:
                result["Browser"] = broswer_parsing(log)
                result["Date_Month"], result["Date_Time"] = date_parser(result["Date"])
                dict_list.append(result)
    return dict_list

# Function to parse error information from log entry
def error_parser(string):
    result = string.split("]")
    return result[0], result[1], result[3], result[4]

# Function to process error logs and return a list of dictionaries
def process_error_logs(error_log_path):
    erro_dict = {}
    erro_list = []
    with open(error_log_path, "r") as error_log:
        for log in error_log:
            result = export_file(log)
            if result:
                erro_dict["Date"], erro_dict["Error_name"], erro_dict["Client"], erro_dict["Error"] = error_parser(result)
                erro_dict["Date"] = erro_dict["Date"].replace("[", "")
                erro_dict["Error_name"] = erro_dict["Error_name"].replace("[", "")
                erro_dict["Client"] = erro_dict["Client"].replace("[", "")
                erro_list.append(erro_dict.copy())
    return erro_list

# Function to plot access timeline
def plot_access_timeline(timeline_dates, timeline_ips):
    plt.figure(figsize=(10, 5))
    plt.plot(timeline_dates, timeline_ips, marker='o', linestyle='-', color='deeppink')
    plt.title('Access Log Timeline')
    plt.xlabel('Date and Time')
    plt.ylabel('IP Address')
    plt.xticks(rotation=45)
    plt.gca().xaxis.set_major_formatter(mdates.DateFormatter('%d-%b %H:%M'))
    plt.tight_layout()
    plt.savefig("/home/mborsos/access_timeline.png", bbox_inches='tight')

# Function to plot error timeline
def plot_error_timeline(grouped_errors):
    plt.figure(figsize=(50, 20))
    plt.subplots_adjust(bottom=0.2)
    plt.subplot(2, 1, 2)
    yticklabels = [f"{error[:83]}\n{error[83:]}" if len(error) > 83 else error for error in grouped_errors.keys()]

    for error, dates in grouped_errors.items():
        plt.plot(dates, [error] * len(dates), marker='o', linestyle='-', label=error)

    plt.title('Error Log Timeline (Grouped by Errors Name)')
    plt.xlabel('Date and Time')
    plt.ylabel('Error')
    plt.xticks(rotation=45)
    plt.gca().xaxis.set_major_formatter(mdates.DateFormatter('%d-%b %H:%M'))
    plt.yticks(range(len(grouped_errors)), yticklabels)
    plt.subplots_adjust(left=0.1, right=0.9, top=0.9, bottom=0.1)
    plt.tight_layout()
    plt.savefig("/home/mborsos/timelines_grouped.png", bbox_inches='tight')

# Function to plot IP address frequency
def plot_ip_frequency(ip_counts):
    plt.figure(figsize=(30, 20))
    plt.subplots_adjust(bottom=0.2)

    ips, counts = zip(*ip_counts.items())

    plt.subplot(2, 2, 1)
    plt.bar(ips, counts, color='skyblue')
    plt.title('IP Address Frequency')
    plt.xlabel('IP Address')
    plt.ylabel('Frequency')
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.savefig("/home/mborsos/ip_grouped.png", bbox_inches='tight')

# Function to plot IP and browser diagram
def plot_ip_browser_diagram(grouped_browsers):
    plt.figure(figsize=(15, 10))

    unique_ips = list(grouped_browsers.keys())
    ip_indices = {ip: i for i, ip in enumerate(unique_ips)}

    for ip, browsers in grouped_browsers.items():
        plt.scatter([ip_indices[ip]] * len(browsers), browsers, marker='o', label=ip)

    plt.xticks(list(ip_indices.values()), list(unique_ips))

    plt.title('Diagram: IP Addresses and Browsers')
    plt.xlabel('IP Address')
    plt.ylabel('Browser')
    plt.savefig("/home/mborsos/ip_browser.png", bbox_inches='tight')

def main():
    access_log_path = "/var/log/apache2/access_log"
    error_log_path = "/var/log/apache2/error_log"

    # Process logs
    dict_list = process_access_logs(access_log_path)
    erro_list = process_error_logs(error_log_path)

    # Plotting access timeline
    timeline_dates = [datetime.strptime(entry["Date"], "%d/%b/%Y:%H:%M:%S") for entry in dict_list if "Date" in entry]
    timeline_ips = [entry["IP"] for entry in dict_list if "Date" in entry]
    plot_access_timeline(timeline_dates, timeline_ips)

    # Plotting error timeline
    timeline_dates_error = [datetime.strptime(entry["Date"], "%a %b %d %H:%M:%S.%f %Y") for entry in erro_list]
    timeline_error = [entry["Error"] for entry in erro_list]
    grouped_errors = defaultdict(list)
    for date, error in zip(timeline_dates_error, timeline_error):
        grouped_errors[error].append(date)
    plot_error_timeline(grouped_errors)

    # Plotting IP address frequency
    ip_counts = defaultdict(int)
    for entry in dict_list:
        ip_counts[entry["IP"]] += 1
    plot_ip_frequency(ip_counts)

    # Plotting IP and browser diagram
    grouped_browsers = defaultdict(list)
    for entry in dict_list:
        grouped_browsers[entry["IP"]].append(entry["Browser"])
    plot_ip_browser_diagram(grouped_browsers)

    plt.show()

if __name__ == "__main__":
    main()
