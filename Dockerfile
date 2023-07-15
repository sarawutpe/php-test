# Use the official CentOS 7 base image
FROM centos:7

# Update packages and install necessary dependencies
RUN yum -y update && \
    yum -y install wget && \
    yum -y install epel-release

# C
RUN yum install -y wget && wget -O install.sh http://www.aapanel.com/script/install_6.0_en.sh && bash install.sh aapanel

# Expose ports for aaPanel
EXPOSE 8888 888 80

# Start aaPanel
CMD ["/etc/init.d/bt", "start"] && ["/bin/bash"]
