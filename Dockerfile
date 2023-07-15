# Use the official CentOS 7 base image
FROM centos:7

# Update packages and install necessary dependencies
RUN yum -y update && \
    yum -y install wget && \
    yum -y install epel-release

# Download and run aaPanel installation script
RUN wget -O install.sh http://www.aapanel.com/script/install-ubuntu_6.0_en.sh && \
    bash install.sh aapanel && \
    rm install.sh

# Expose ports for aaPanel
EXPOSE 8888 888 80

# Start aaPanel
CMD ["/etc/init.d/bt", "start"] && ["/bin/bash"]
