.. image:: img/EC3-logo-3d.png
   :height: 50px
   :width: 41 px
   :scale: 50 %
   :alt: EC3 logo
   :align: right
   
.. Elastic Cloud Computing Cluster (EC3)
=====================================

Elastic Cloud Computing Cluster (EC3) is a tool to create elastic virtual clusters on top
of Infrastructure as a Service (IaaS) providers, either public (such as `Amazon Web Services`_,
`Google Cloud`_ or `Microsoft Azure`_)
or on-premises (such as `OpenNebula`_ and `OpenStack`_). We offer recipes to deploy `TORQUE`_
(optionally with `MAUI`_) and `SLURM`_ clusters that can be self-managed with `CLUES`_:
it starts with a single-node cluster and working nodes will be dynamically deployed and provisioned
to fit increasing load, in terms of the number of jobs at the LRMS (Local Resource Management System). Working nodes will be undeployed when they are idle.
This introduces a cost-efficient approach for Cluster-based computing.

This repository includes the developments of the service EC3aaS, the web interface of EC3, that is part of the developments of the `ATMOSPHERE`_ project. More information about EC3 and the CLI version can be found in `EC3 Command-line Interface`_


The webpage has been developed by using the `Agency`_ theme for `Bootstrap`_ created by `Start Bootstrap`_. 


.. _`EC3 Command-line Interface`: http://ec3.readthedocs.org/en/devel/ec3.html
.. _`Agency`: http://startbootstrap.com/template-overviews/agency/
.. _`Start Bootstrap`: http://startbootstrap.com/
.. _`Bootstrap`: http://getbootstrap.com/
.. _`EC3aaS`: http://servproject.i3m.upv.es/ec3/
.. _`CLUES`: http://www.grycap.upv.es/clues/
.. _`RADL`: http://www.grycap.upv.es/im/doc/radl.html
.. _`TORQUE`: http://www.adaptivecomputing.com/products/open-source/torque
.. _`MAUI`: http://www.adaptivecomputing.com/products/open-source/maui/
.. _`SLURM`: http://slurm.schedmd.com/
.. _`Scientific Linux`: https://www.scientificlinux.org/
.. _`Ubuntu`: http://www.ubuntu.com/
.. _`OpenNebula`: http://www.opennebula.org/
.. _`OpenStack`: http://www.openstack.org/
.. _`Amazon Web Services`: https://aws.amazon.com/
.. _`Google Cloud`: http://cloud.google.com/
.. _`Microsoft Azure`: http://azure.microsoft.com/
.. _`IM`: https://github.com/grycap/im
.. _`ATMOSPHERE`: https://www.atmosphere-eubrazil.eu/
