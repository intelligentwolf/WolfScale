<?php
$page_title = 'REST API Documentation — WolfStack Docs';
$page_desc = 'WolfStack REST API reference — complete endpoint documentation for managing servers, containers, storage, networking, backups, orchestration and more. Enterprise API key support with scoped permissions.';
$active = 'wolfstack-api.php';
$page_css = '
.api-side-nav{position:sticky;top:80px;align-self:start;max-height:calc(100vh - 100px);overflow-y:auto;padding-right:12px;}
.api-side-nav a{display:block;padding:4px 0;font-size:11px;color:var(--text-secondary);text-decoration:none;border-left:2px solid transparent;padding-left:10px;transition:all 0.15s;}
.api-side-nav a:hover{color:var(--text-primary);border-left-color:var(--text-secondary);}
.api-side-nav a.active{color:#60a5fa;border-left-color:#60a5fa;font-weight:500;}
.api-side-nav .nav-heading{font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-secondary);opacity:0.6;margin-top:10px;margin-bottom:2px;padding-left:10px;}
.api-side-nav .nav-heading:first-child{margin-top:0;}
.method-get{background:rgba(34,197,94,0.15);color:#4ade80;padding:2px 6px;border-radius:3px;}
.method-post{background:rgba(59,130,246,0.15);color:#60a5fa;padding:2px 6px;border-radius:3px;}
.method-delete{background:rgba(239,68,68,0.15);color:#f87171;padding:2px 6px;border-radius:3px;}
.method-put{background:rgba(251,191,36,0.15);color:#fbbf24;padding:2px 6px;border-radius:3px;}
.method-patch{background:rgba(168,85,247,0.15);color:#c084fc;padding:2px 6px;border-radius:3px;}
@media(max-width:900px){.api-grid{display:block !important;}.api-side-nav{display:none;}}
';
include 'includes/head.php';
?>
<body>
<div class="wiki-layout">
    <?php include 'includes/sidebar.php'; ?>
    <main class="wiki-content" style="max-width:1400px;">

            <div class="content-section">
                <h2>REST API Reference</h2>
                <img src="images/screenshots/settings-security.png" alt="WolfStack REST API key management" class="screenshot" loading="lazy" style="border-radius:12px;border:1px solid var(--border-color);margin:1.5rem 0;">
                <div style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,rgba(220,38,38,0.1),rgba(239,68,68,0.05));border:1px solid rgba(220,38,38,0.25);border-radius:8px;padding:8px 16px;margin-bottom:16px;font-size:0.85rem;">
                    <span style="font-size:1.1rem;">&#128273;</span>
                    <span><strong>Enterprise Feature</strong> &mdash; API key management requires an <a href="enterprise.php" style="color:#ef4444;font-weight:600;">Enterprise license</a>. All endpoints listed below work with standard session cookie authentication in every edition.</span>
                </div>
                <p>WolfStack exposes a comprehensive REST API covering every feature available in the web UI. Enterprise customers can create scoped API keys for programmatic access from CI/CD pipelines, monitoring tools, custom scripts, and third-party integrations. All endpoints return JSON and use the base URL <code>https://your-server:8553</code>.</p>
            </div>

            <div class="api-grid" style="display:grid;grid-template-columns:220px 1fr;gap:32px;">

            <!-- Side Navigation -->
            <nav class="api-side-nav">
                <div class="nav-heading">Getting Started</div>
                <a href="#authentication">Authentication</a>
                <a href="#scopes">API Key Scopes</a>
                <div class="nav-heading">Endpoints</div>
                <a href="#dashboard">Dashboard &amp; Metrics</a>
                <a href="#cluster">Cluster &amp; Nodes</a>
                <a href="#docker">Docker Containers</a>
                <a href="#lxc">LXC Containers</a>
                <a href="#compose">Docker Compose</a>
                <a href="#storage">Storage &amp; Disks</a>
                <a href="#zfs">ZFS</a>
                <a href="#ceph">Ceph</a>
                <a href="#networking">Networking</a>
                <a href="#wolfnet">WolfNet</a>
                <a href="#wireguard">WireGuard Bridge</a>
                <a href="#backups">Backups</a>
                <a href="#files">File Manager</a>
                <a href="#security">Security</a>
                <a href="#certificates">Certificates</a>
                <a href="#alerting">Alerting</a>
                <a href="#statuspages">Status Pages</a>
                <a href="#appstore">App Store</a>
                <a href="#wolfrun">WolfRun Orchestration</a>
                <a href="#kubernetes">Kubernetes (WolfKube)</a>
                <a href="#wolfflow">WolfFlow Automation</a>
                <a href="#cron">Cron Jobs</a>
                <a href="#mysql">MySQL/MariaDB Editor</a>
                <a href="#ai">AI Agent</a>
                <a href="#secrets">Secrets Manager</a>
                <a href="#components">Components &amp; Services</a>
                <a href="#system">System</a>
                <a href="#apikeys">Enterprise API Keys</a>
                <a href="#nginx">Nginx (WolfProxy)</a>
                <div class="nav-heading">Reference</div>
                <a href="#errors">Error Handling</a>
                <a href="#ratelimiting">Rate Limiting</a>
                <a href="#license">License Installation</a>
            </nav>

            <!-- Main Content -->
            <div>

            <!-- Authentication -->
            <div class="content-section" id="authentication">
                <h2>Authentication</h2>
                <p>Three authentication methods are supported. All requests must include one of these:</p>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:12px;margin:16px 0;">
                    <div style="background:var(--bg-tertiary);border:1px solid var(--border-color);border-radius:8px;padding:16px;">
                        <h3 style="font-size:0.92rem;margin-bottom:6px;">API Key <span style="font-size:0.7rem;background:rgba(220,38,38,0.15);color:#ef4444;padding:2px 8px;border-radius:4px;margin-left:6px;">Enterprise</span></h3>
                        <p style="font-size:0.82rem;color:var(--text-secondary);">Send your API key in the <code>X-API-Key</code> header or as a <code>Bearer</code> token in the <code>Authorization</code> header. Keys are prefixed with <code>wsk_</code> and support scoped permissions.</p>
                    </div>
                    <div style="background:var(--bg-tertiary);border:1px solid var(--border-color);border-radius:8px;padding:16px;">
                        <h3 style="font-size:0.92rem;margin-bottom:6px;">Session Cookie</h3>
                        <p style="font-size:0.82rem;color:var(--text-secondary);">After logging in via the web UI or <code>POST /api/login</code>, the browser sends the <code>wolfstack_session</code> cookie automatically with every request. Works in all editions.</p>
                    </div>
                    <div style="background:var(--bg-tertiary);border:1px solid var(--border-color);border-radius:8px;padding:16px;">
                        <h3 style="font-size:0.92rem;margin-bottom:6px;">Cluster Secret</h3>
                        <p style="font-size:0.82rem;color:var(--text-secondary);">Inter-node communication uses the <code>X-WolfStack-Secret</code> header with the shared cluster secret. Used internally for node-to-node API calls.</p>
                    </div>
                </div>

                <h3>API Key Authentication (Enterprise)</h3>
                <p>Create API keys from <strong>Settings &rarr; API Keys</strong> in the web UI. Use them in requests:</p>
<pre><code># Using X-API-Key header (recommended)
curl -s -H "X-API-Key: wsk_a1b2c3d4e5f6..." \
  https://your-server:8553/api/metrics

# Using Authorization: Bearer header
curl -s -H "Authorization: Bearer wsk_a1b2c3d4e5f6..." \
  https://your-server:8553/api/metrics</code></pre>

                <h3>Session Cookie Authentication</h3>
                <p>Log in first to obtain a session cookie, then use it for subsequent requests:</p>
<pre><code># Log in and save the session cookie
curl -c cookies.txt -X POST -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"yourpassword"}' \
  https://your-server:8553/api/login

# Use the cookie for API calls
curl -b cookies.txt https://your-server:8553/api/metrics</code></pre>

                <h3>Cluster Secret Authentication</h3>
                <p>Used for inter-node communication within a cluster:</p>
<pre><code># Node-to-node request with cluster secret
curl -s -H "X-WolfStack-Secret: your-cluster-secret" \
  https://node-02:8553/api/metrics</code></pre>
            </div>

            <!-- API Key Scopes -->
            <div class="content-section" id="scopes">
                <h2>API Key Scopes</h2>
                <p>Each API key can be restricted to specific scopes. Assign only the permissions your integration needs:</p>
                <table class="feature-table" style="width:100%;font-size:0.85rem;">
                    <thead><tr><th style="width:140px;">Scope</th><th>Access</th></tr></thead>
                    <tbody>
                        <tr><td><code>*</code></td><td>Full access &mdash; all endpoints, all methods</td></tr>
                        <tr><td><code>read</code></td><td>Read-only &mdash; all GET endpoints</td></tr>
                        <tr><td><code>containers</code></td><td>Docker &amp; LXC container management</td></tr>
                        <tr><td><code>vms</code></td><td>Virtual machine management</td></tr>
                        <tr><td><code>storage</code></td><td>Storage mounts, disks, ZFS, and Ceph</td></tr>
                        <tr><td><code>networking</code></td><td>Network interfaces, DNS, VLANs, WolfNet</td></tr>
                        <tr><td><code>backup</code></td><td>Backup schedules, targets, and restore operations</td></tr>
                        <tr><td><code>appstore</code></td><td>App store browsing, install, and management</td></tr>
                        <tr><td><code>statuspage</code></td><td>Status page monitors, pages, and incidents</td></tr>
                        <tr><td><code>cluster</code></td><td>Cluster nodes, join, and settings</td></tr>
                        <tr><td><code>wolfrun</code></td><td>WolfRun container orchestration services</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Dashboard & Metrics -->
            <div class="content-section" id="dashboard">
                <h2>Dashboard &amp; Metrics</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/metrics</code></td><td>Current system metrics: CPU usage, memory, swap, load averages, disk I/O, network throughput, and uptime</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/metrics/history</code></td><td>Rolling historical metrics (10-minute window) for graphing CPU, memory, and network trends</td></tr>
                    </tbody>
                </table>
<pre><code># Get current system metrics
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/metrics | jq .
{
  "hostname": "node-01",
  "cpu_usage_percent": 12.5,
  "memory_total": 16777216,
  "memory_used": 7589324,
  "memory_percent": 45.2,
  "load_avg": [0.85, 1.02, 0.97],
  "uptime_seconds": 864000,
  ...
}

# Get metrics history for charts
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/metrics/history | jq '.[0]'</code></pre>
            </div>

            <!-- Cluster & Nodes -->
            <div class="content-section" id="cluster">
                <h2>Cluster &amp; Nodes</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/nodes</code></td><td>List all cluster nodes with hostname, IP, status, CPU/memory usage, and role</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/nodes</code></td><td>Join a new node to the cluster using its address and join token</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/nodes/{id}</code></td><td>Get detailed information for a specific node including all metrics and capabilities</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/nodes/{id}</code></td><td>Remove a node from the cluster (does not shut down the remote node)</td></tr>
                        <tr><td><code class="method-patch">PATCH</code></td><td><code>/api/nodes/{id}/settings</code></td><td>Update node-specific settings such as display name, role, or direct login access</td></tr>
                    </tbody>
                </table>
<pre><code># List all nodes in the cluster
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/nodes | jq .

# Join a new node
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"address":"192.168.1.20:8553","token":"join_token_here"}' \
  https://server:8553/api/nodes</code></pre>
            </div>

            <!-- Docker Containers -->
            <div class="content-section" id="docker">
                <h2>Docker Containers</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/docker</code></td><td>List all Docker containers with name, image, state, ports, and resource usage</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/create</code></td><td>Create and start a new Docker container from an image with full configuration (ports, volumes, env vars, restart policy)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/pull</code></td><td>Pull a Docker image from a registry (Docker Hub, GHCR, or custom registry)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/docker/search</code></td><td>Search Docker Hub for available images by keyword</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/docker/{id}/logs</code></td><td>Retrieve container logs with optional tail limit and timestamp filters</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/{id}/action</code></td><td>Perform an action on a container: start, stop, restart, pause, unpause, or remove</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/{id}/clone</code></td><td>Clone a container with a new name, preserving its configuration and volumes</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/{id}/migrate</code></td><td>Migrate a container to another node in the cluster via image export/import</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/docker/{id}/inspect</code></td><td>Full Docker inspect output including networking, mounts, config, and state details</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/{id}/config</code></td><td>Update container configuration (restart policy, resource limits, labels)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/{id}/env</code></td><td>Update environment variables on a container (recreates the container with new env)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/docker/images</code></td><td>List all locally available Docker images with size, tags, and creation date</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/containers/docker/images/{id}</code></td><td>Remove a Docker image from the local image store</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/docker/import</code></td><td>Import a Docker container from an exported tar archive</td></tr>
                    </tbody>
                </table>
<pre><code># List all Docker containers
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/containers/docker | jq .

# Create a new container
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "name": "my-nginx",
    "image": "nginx:latest",
    "ports": ["80:80","443:443"],
    "volumes": ["/data/nginx:/etc/nginx/conf.d"],
    "env": ["NGINX_HOST=example.com"],
    "restart_policy": "unless-stopped"
  }' \
  https://server:8553/api/containers/docker/create

# Stop a container
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"action":"stop"}' \
  https://server:8553/api/containers/docker/abc123def/action</code></pre>
            </div>

            <!-- LXC Containers -->
            <div class="content-section" id="lxc">
                <h2>LXC Containers</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/lxc</code></td><td>List all LXC containers with name, state, distribution, IP addresses, and resource usage</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/lxc/create</code></td><td>Create a new LXC container from a distribution template with resource limits</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/lxc/templates</code></td><td>List available LXC distribution templates (Ubuntu, Debian, Alpine, etc.)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/lxc/{name}/action</code></td><td>Perform an action on an LXC container: start, stop, restart, freeze, unfreeze, or delete</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/lxc/{name}/clone</code></td><td>Clone an LXC container with a new name, including its filesystem snapshot</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/lxc/{name}/config</code></td><td>Get the full LXC configuration for a container (resource limits, networking, mounts)</td></tr>
                        <tr><td><code class="method-put">PUT</code></td><td><code>/api/containers/lxc/{name}/config</code></td><td>Update LXC container configuration (CPU, memory, network, autostart settings)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/lxc/{name}/export</code></td><td>Export an LXC container as a tar archive for backup or migration</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/lxc/{name}/migrate</code></td><td>Migrate an LXC container to another node in the cluster</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/containers/lxc/{name}/mounts</code></td><td>List bind mounts attached to an LXC container</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/containers/lxc/{name}/mounts</code></td><td>Add a new bind mount to an LXC container (host path mapped into container)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/containers/lxc/{name}/mounts</code></td><td>Remove a bind mount from an LXC container</td></tr>
                    </tbody>
                </table>
<pre><code># List all LXC containers
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/containers/lxc | jq .

# Create a new LXC container
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "name": "web-server",
    "template": "ubuntu",
    "release": "24.04",
    "memory_limit": "2G",
    "cpu_limit": "2"
  }' \
  https://server:8553/api/containers/lxc/create</code></pre>
            </div>

            <!-- Docker Compose -->
            <div class="content-section" id="compose">
                <h2>Docker Compose</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/compose/stacks</code></td><td>List all Compose stacks with their status, service count, and project directory</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks</code></td><td>Create a new Compose stack by providing a name and docker-compose.yml content</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/compose/stacks/{name}</code></td><td>Delete a Compose stack, stopping all services and removing the project directory</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/compose/stacks/{name}/compose</code></td><td>Get the docker-compose.yml file contents for a stack</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks/{name}/compose</code></td><td>Update the docker-compose.yml file contents for a stack</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks/{name}/up</code></td><td>Bring up a Compose stack (equivalent to <code>docker compose up -d</code>)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks/{name}/down</code></td><td>Bring down a Compose stack, stopping and removing all services</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks/{name}/pull</code></td><td>Pull the latest images for all services in a Compose stack</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks/{name}/restart</code></td><td>Restart the running containers of a Compose stack in place (<code>docker compose restart</code>) &mdash; same containers, same image</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/compose/stacks/{name}/recreate</code></td><td>Recreate every container in a Compose stack from its compose file (<code>docker compose up -d --force-recreate --remove-orphans</code>); volumes are kept. Same report as <code>/up</code></td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/compose/stacks/{name}/logs</code></td><td>Retrieve combined logs from all services in a Compose stack</td></tr>
                    </tbody>
                </table>
<pre><code># List all Compose stacks
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/compose/stacks | jq .

# Create a new stack
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "name": "monitoring",
    "compose": "version: \"3.8\"\nservices:\n  prometheus:\n    image: prom/prometheus\n    ports:\n      - 9090:9090"
  }' \
  https://server:8553/api/compose/stacks

# Bring a stack up
curl -X POST -H "X-API-Key: wsk_..." \
  https://server:8553/api/compose/stacks/monitoring/up</code></pre>
            </div>

            <!-- Storage & Disks -->
            <div class="content-section" id="storage">
                <h2>Storage &amp; Disks</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/storage/list</code></td><td>List all block devices and their partitions with size, filesystem type, and mount point</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/storage/mounts</code></td><td>List all configured storage mounts (S3, NFS, SSHFS, WolfDisk, local) with status</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/mounts</code></td><td>Create a new storage mount configuration (specify type, credentials, mount point)</td></tr>
                        <tr><td><code class="method-put">PUT</code></td><td><code>/api/storage/mounts/{id}</code></td><td>Update an existing storage mount configuration</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/storage/mounts/{id}</code></td><td>Delete a storage mount configuration (unmounts first if currently mounted)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/mounts/{id}/mount</code></td><td>Mount a configured storage location to its mount point</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/mounts/{id}/unmount</code></td><td>Unmount a currently mounted storage location</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/storage/disk-info</code></td><td>Detailed disk information including SMART data, temperature, and health status</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/disk/partition</code></td><td>Create a new partition on a block device</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/disk/format</code></td><td>Format a partition with a specified filesystem (ext4, xfs, btrfs, etc.)</td></tr>
                    </tbody>
                </table>
<pre><code># List all storage mounts
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/storage/mounts | jq .

# Create an S3 mount
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "name": "backup-bucket",
    "mount_type": "s3",
    "bucket": "my-backups",
    "endpoint": "https://s3.amazonaws.com",
    "access_key": "AKIA...",
    "secret_key": "...",
    "mount_point": "/mnt/s3-backups"
  }' \
  https://server:8553/api/storage/mounts</code></pre>
            </div>

            <!-- ZFS -->
            <div class="content-section" id="zfs">
                <h2>ZFS</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/storage/zfs/pools</code></td><td>List all ZFS pools with health status, size, used/free space, and properties</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/storage/zfs/datasets</code></td><td>List all ZFS datasets and volumes with mount point, compression, and quota info</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/storage/zfs/snapshots</code></td><td>List all ZFS snapshots with creation time, referenced size, and parent dataset</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/zfs/snapshot</code></td><td>Create a new ZFS snapshot of a dataset or volume</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/storage/zfs/snapshot</code></td><td>Delete a ZFS snapshot by name</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/storage/zfs/pool/scrub</code></td><td>Start a scrub operation on a ZFS pool to verify data integrity</td></tr>
                    </tbody>
                </table>
<pre><code># List ZFS pools
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/storage/zfs/pools | jq .

# Create a snapshot
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"dataset":"tank/data","snapshot_name":"daily-2026-04-04"}' \
  https://server:8553/api/storage/zfs/snapshot</code></pre>
            </div>

            <!-- Ceph -->
            <div class="content-section" id="ceph">
                <h2>Ceph</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/ceph/status</code></td><td>Ceph cluster health status, IOPS, throughput, OSD count, and PG distribution</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/ceph/bootstrap</code></td><td>Bootstrap a new Ceph cluster on the current node (initializes monitors and managers)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/ceph/pools</code></td><td>Create a new Ceph pool with specified replication factor and PG count</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/ceph/pools/{name}</code></td><td>Delete a Ceph pool (requires confirmation, destroys all data in the pool)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/ceph/osds</code></td><td>Add a new OSD (Object Storage Daemon) to the Ceph cluster using a specified disk</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/ceph/osds/{id}</code></td><td>Remove an OSD from the Ceph cluster (marks out, stops, and purges)</td></tr>
                    </tbody>
                </table>
<pre><code># Get Ceph cluster status
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/ceph/status | jq .

# Create a new pool
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"name":"rbd-pool","size":3,"pg_num":128}' \
  https://server:8553/api/ceph/pools</code></pre>
            </div>

            <!-- Networking -->
            <div class="content-section" id="networking">
                <h2>Networking</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/networking/interfaces</code></td><td>List all network interfaces with IP addresses, MAC, speed, state, and traffic counters</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/networking/dns</code></td><td>Get current DNS resolver configuration (/etc/resolv.conf entries)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/networking/dns</code></td><td>Update DNS resolver configuration with new nameservers and search domains</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/networking/interfaces/{name}/ip</code></td><td>Add an IP address to a network interface</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/networking/interfaces/{name}/ip</code></td><td>Remove an IP address from a network interface</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/networking/vlans</code></td><td>Create a VLAN interface on a parent network interface</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/networking/vlans/{name}</code></td><td>Delete a VLAN interface</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/networking/listening-ports</code></td><td>List all listening TCP/UDP ports with associated process name and PID</td></tr>
                    </tbody>
                </table>
<pre><code># List network interfaces
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/networking/interfaces | jq .

# Create a VLAN
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"parent":"eth0","vlan_id":100}' \
  https://server:8553/api/networking/vlans</code></pre>
            </div>

            <!-- WolfNet -->
            <div class="content-section" id="wolfnet">
                <h2>WolfNet</h2>
                <p>WolfNet is the encrypted overlay network that connects cluster nodes. Uses X25519 key exchange with ChaCha20-Poly1305 encryption.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/networking/wolfnet</code></td><td>Get WolfNet configuration including local IP, subnet, and peer list</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfnet/status</code></td><td>WolfNet daemon status: running/stopped, interface state, connected peers, and traffic stats</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfnet/next-ip</code></td><td>Get the next available IP address in the WolfNet subnet for a new peer</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/networking/wolfnet/peers</code></td><td>Add a peer to the WolfNet overlay network with its public key and endpoint</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/networking/wolfnet/peers</code></td><td>Remove a peer from the WolfNet overlay network</td></tr>
                    </tbody>
                </table>
<pre><code># Check WolfNet status
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/wolfnet/status | jq .

# Add a WolfNet peer
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"public_key":"base64key...","endpoint":"203.0.113.10:51820","allowed_ip":"10.99.0.5/32"}' \
  https://server:8553/api/networking/wolfnet/peers</code></pre>
            </div>

            <!-- WireGuard Bridge -->
            <div class="content-section" id="wireguard">
                <h2>WireGuard Bridge</h2>
                <p>Create WireGuard VPN tunnels for remote access to cluster networks. Each cluster can have its own WireGuard interface with client configurations.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/networking/wireguard</code></td><td>List all WireGuard interfaces with their status, peer count, and traffic stats</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/networking/wireguard/{cluster}/init</code></td><td>Initialize a new WireGuard interface for a cluster with server keypair and listen port</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/networking/wireguard/{cluster}/clients</code></td><td>Generate a new client configuration with keypair and assigned IP from the tunnel subnet</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/networking/wireguard/{cluster}/clients/{id}/config</code></td><td>Download the WireGuard client configuration file (.conf) for import into a WireGuard client app</td></tr>
                    </tbody>
                </table>
<pre><code># Initialize WireGuard for a cluster
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"listen_port":51821,"address":"10.100.0.1/24"}' \
  https://server:8553/api/networking/wireguard/production/init

# Generate a client config
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"name":"laptop-paul"}' \
  https://server:8553/api/networking/wireguard/production/clients</code></pre>
            </div>

            <!-- Backups -->
            <div class="content-section" id="backups">
                <h2>Backups</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/backups</code></td><td>List all backup jobs with status, last run time, size, and destination</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/backups</code></td><td>Create a new backup job specifying source paths, destination target, and retention policy</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/backups/{id}</code></td><td>Delete a backup job and optionally its stored backup data</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/backups/{id}/restore</code></td><td>Restore a backup to its original or a specified destination path</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/backups/targets</code></td><td>List available backup targets (local paths, S3 buckets, NFS mounts, remote servers)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/backups/schedules</code></td><td>List all backup schedules with cron expressions, next run time, and assigned jobs</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/backups/schedules</code></td><td>Create or update a backup schedule with cron timing and backup job assignment</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/backups/schedules/{id}</code></td><td>Delete a backup schedule (does not delete the backup jobs or data)</td></tr>
                    </tbody>
                </table>
<pre><code># List all backups
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/backups | jq .

# Create a backup job
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "name": "etc-config-backup",
    "source_paths": ["/etc/wolfstack", "/etc/nginx"],
    "target_id": "s3-backup-target",
    "retention_days": 30
  }' \
  https://server:8553/api/backups</code></pre>
            </div>

            <!-- File Manager -->
            <div class="content-section" id="files">
                <h2>File Manager</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/files/browse</code></td><td>Browse a directory listing with file names, sizes, permissions, modification times, and types</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/files/mkdir</code></td><td>Create a new directory at the specified path</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/files/delete</code></td><td>Delete a file or directory (recursive for directories)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/files/rename</code></td><td>Rename or move a file or directory to a new path</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/files/upload</code></td><td>Upload a file to the specified directory (multipart form data)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/files/download</code></td><td>Download a file from the server as a binary stream</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/files/search</code></td><td>Search for files by name pattern within a directory tree</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/files/read</code></td><td>Read the contents of a text file for viewing or editing</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/files/write</code></td><td>Write content to a text file (creates or overwrites)</td></tr>
                    </tbody>
                </table>
<pre><code># Browse /etc directory
curl -s -H "X-API-Key: wsk_..." \
  "https://server:8553/api/files/browse?path=/etc" | jq .

# Read a config file
curl -s -H "X-API-Key: wsk_..." \
  "https://server:8553/api/files/read?path=/etc/hostname" | jq .

# Upload a file
curl -X POST -H "X-API-Key: wsk_..." \
  -F "file=@backup.tar.gz" -F "path=/tmp" \
  https://server:8553/api/files/upload</code></pre>
            </div>

            <!-- Security -->
            <div class="content-section" id="security">
                <h2>Security</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/security/status</code></td><td>Security overview: UFW status, Fail2ban jails, banned IPs, iptables rules, and listening ports</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/security/ufw/rule</code></td><td>Add a UFW firewall rule (allow/deny by port, protocol, and source IP)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/security/ufw/rule</code></td><td>Remove a UFW firewall rule by rule number or specification</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/security/ufw/toggle</code></td><td>Enable or disable the UFW firewall</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/security/fail2ban/unban</code></td><td>Unban an IP address from all Fail2ban jails</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/security/updates/check</code></td><td>Check for available system package updates (apt/dnf/pacman)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/security/updates/apply</code></td><td>Apply all available system package updates</td></tr>
                    </tbody>
                </table>
<pre><code># Get security status
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/security/status | jq .

# Add a UFW rule to allow HTTPS
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"action":"allow","port":"443","protocol":"tcp"}' \
  https://server:8553/api/security/ufw/rule</code></pre>
            </div>

            <!-- Certificates -->
            <div class="content-section" id="certificates">
                <h2>Certificates</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/certificates</code></td><td>Request a new TLS certificate via Let&rsquo;s Encrypt (ACME) for the specified domain</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/certificates/list</code></td><td>List all managed TLS certificates with domain, expiry date, issuer, and renewal status</td></tr>
                    </tbody>
                </table>
<pre><code># List certificates
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/certificates/list | jq .

# Request a new certificate
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"domain":"dashboard.example.com","email":"admin@example.com"}' \
  https://server:8553/api/certificates</code></pre>
            </div>

            <!-- Alerting -->
            <div class="content-section" id="alerting">
                <h2>Alerting</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/alerts/config</code></td><td>Get alerting configuration: thresholds, notification channels (email/webhook), and recipient list</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/alerts/config</code></td><td>Update alerting configuration with new thresholds, email settings, or webhook URLs</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/alerts/test</code></td><td>Send a test alert notification to verify email/webhook delivery</td></tr>
                    </tbody>
                </table>
<pre><code># Get alert configuration
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/alerts/config | jq .

# Update alert thresholds
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "cpu_threshold": 90,
    "memory_threshold": 85,
    "disk_threshold": 95,
    "email_recipients": ["ops@example.com"],
    "webhook_url": "https://hooks.slack.com/services/..."
  }' \
  https://server:8553/api/alerts/config</code></pre>
            </div>

            <!-- Status Pages -->
            <div class="content-section" id="statuspages">
                <h2>Status Pages</h2>
                <p>Uptime monitoring with public-facing status pages. All entities are cluster-scoped &mdash; pass the <code>cluster</code> query parameter.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/statuspage/monitors</code></td><td>List all uptime monitors with check type (HTTP, TCP, ping), interval, and current status</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/statuspage/monitors</code></td><td>Create a new uptime monitor with URL/host, check type, interval, and expected response</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/statuspage/monitors/{id}</code></td><td>Delete an uptime monitor and its historical check data</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/statuspage/pages</code></td><td>List all public status pages with their slug, title, assigned monitors, and theme</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/statuspage/pages</code></td><td>Create a new public status page with a URL slug, title, and list of monitors to display</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/statuspage/pages/{id}</code></td><td>Delete a public status page (monitors continue running)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/statuspage/incidents</code></td><td>List all incidents with status (investigating, identified, monitoring, resolved) and updates</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/statuspage/incidents</code></td><td>Create a new incident with title, description, severity, and affected monitors</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/statuspage/incidents/{id}</code></td><td>Delete an incident record</td></tr>
                    </tbody>
                </table>
<pre><code># List monitors for a cluster
curl -s -H "X-API-Key: wsk_..." \
  "https://server:8553/api/statuspage/monitors?cluster=production" | jq .

# Create an HTTP monitor
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "cluster": "production",
    "name": "Main Website",
    "url": "https://example.com",
    "check_type": "http",
    "interval_seconds": 30,
    "expected_status": 200
  }' \
  https://server:8553/api/statuspage/monitors</code></pre>
            </div>

            <!-- App Store -->
            <div class="content-section" id="appstore">
                <h2>App Store</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/appstore/apps</code></td><td>List all available applications in the app store with categories, descriptions, and install types</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/appstore/apps/{id}</code></td><td>Get detailed information about a specific application including configuration options</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/appstore/apps/{id}/prepare-install</code></td><td>Prepare an app for installation and return the configuration form (ports, volumes, env vars)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/appstore/installed</code></td><td>List all installed applications with their status, version, and resource usage</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/appstore/installed/{id}</code></td><td>Uninstall an application and remove its containers, volumes, and configuration</td></tr>
                    </tbody>
                </table>
<pre><code># Browse available apps
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/appstore/apps | jq '.[0:3]'

# Prepare to install an app
curl -X POST -H "X-API-Key: wsk_..." \
  https://server:8553/api/appstore/apps/nextcloud/prepare-install | jq .</code></pre>
            </div>

            <!-- WolfRun Orchestration -->
            <div class="content-section" id="wolfrun">
                <h2>WolfRun Orchestration</h2>
                <p>Manage multi-container services across cluster nodes with automatic scaling, health checks, and rolling updates.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfrun/services</code></td><td>List all orchestrated services with replica count, status, health, and assigned nodes</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/wolfrun/services</code></td><td>Create a new orchestrated service with image, replicas, placement, and health check config</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/wolfrun/services/adopt</code></td><td>Adopt an existing running container as a WolfRun-managed service</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfrun/services/{id}</code></td><td>Get detailed service information including per-replica status and deployment history</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/wolfrun/services/{id}</code></td><td>Delete an orchestrated service and stop all its replicas across the cluster</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/wolfrun/services/{id}/scale</code></td><td>Scale a service to a target replica count across available nodes</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/wolfrun/services/{id}/action</code></td><td>Perform a service action: restart all replicas, rolling update, or force redeploy</td></tr>
                    </tbody>
                </table>
<pre><code># List orchestrated services
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/wolfrun/services | jq .

# Scale a service to 5 replicas
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"replicas":5}' \
  https://server:8553/api/wolfrun/services/svc_abc123/scale</code></pre>
            </div>

            <!-- Kubernetes (WolfKube) -->
            <div class="content-section" id="kubernetes">
                <h2>Kubernetes (WolfKube)</h2>
                <p>Manage lightweight Kubernetes clusters provisioned by WolfStack. Deploy apps, manage pods, and scale deployments.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/kubernetes/clusters</code></td><td>List all Kubernetes clusters with version, node count, status, and resource usage</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/kubernetes/clusters</code></td><td>Create a new Kubernetes cluster (provisions control plane and worker nodes)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/kubernetes/clusters/{id}</code></td><td>Delete a Kubernetes cluster and tear down all its nodes</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/kubernetes/clusters/{id}/pods</code></td><td>List all pods in the cluster with namespace, status, restarts, and resource usage</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/kubernetes/clusters/{id}/pods/{name}</code></td><td>Delete a pod (the controller will recreate it if managed by a deployment)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/kubernetes/clusters/{id}/deployments</code></td><td>List all deployments with replica count, available/unavailable pods, and image versions</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/kubernetes/clusters/{id}/deployments/{name}</code></td><td>Delete a deployment and all its managed pods</td></tr>
                        <tr><td><code class="method-patch">PATCH</code></td><td><code>/api/kubernetes/clusters/{id}/deployments/{name}/scale</code></td><td>Scale a deployment to a specified number of replicas</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/kubernetes/clusters/{id}/deploy-app</code></td><td>Deploy an application to the cluster from an image with port, replicas, and env config</td></tr>
                    </tbody>
                </table>
<pre><code># List Kubernetes clusters
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/kubernetes/clusters | jq .

# Scale a deployment
curl -X PATCH -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"replicas":3}' \
  https://server:8553/api/kubernetes/clusters/k8s_01/deployments/web-app/scale</code></pre>
            </div>

            <!-- WolfFlow Automation -->
            <div class="content-section" id="wolfflow">
                <h2>WolfFlow Automation</h2>
                <p>Visual workflow automation engine. Create workflows with triggers, conditions, and actions to automate server management tasks.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfflow/workflows</code></td><td>List all workflows with name, trigger type, enabled status, and last run time</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/wolfflow/workflows</code></td><td>Create a new workflow with nodes (triggers, conditions, actions) and edge connections</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfflow/workflows/{id}</code></td><td>Get a workflow definition including all nodes, edges, and configuration</td></tr>
                        <tr><td><code class="method-put">PUT</code></td><td><code>/api/wolfflow/workflows/{id}</code></td><td>Update a workflow definition (replaces all nodes and edges)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/wolfflow/workflows/{id}</code></td><td>Delete a workflow and its run history</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/wolfflow/workflows/{id}/run</code></td><td>Manually trigger a workflow run regardless of its configured trigger</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/wolfflow/runs</code></td><td>List workflow run history with status (success, failed, running), duration, and output logs</td></tr>
                    </tbody>
                </table>
<pre><code># List all workflows
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/wolfflow/workflows | jq .

# Manually trigger a workflow
curl -X POST -H "X-API-Key: wsk_..." \
  https://server:8553/api/wolfflow/workflows/wf_abc123/run</code></pre>
            </div>

            <!-- Cron Jobs -->
            <div class="content-section" id="cron">
                <h2>Cron Jobs</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/cron</code></td><td>List all cron jobs on the system with schedule expression, command, and user</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/cron</code></td><td>Create a new cron job with schedule expression, command, and optional user</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/cron/{index}</code></td><td>Delete a cron job by its index in the crontab</td></tr>
                    </tbody>
                </table>
<pre><code># List all cron jobs
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/cron | jq .

# Create a cron job to run backups daily at 2 AM
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"schedule":"0 2 * * *","command":"/usr/local/bin/backup.sh","user":"root"}' \
  https://server:8553/api/cron</code></pre>
            </div>

            <!-- MySQL/MariaDB Editor -->
            <div class="content-section" id="mysql">
                <h2>MySQL/MariaDB Editor</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/mysql/detect</code></td><td>Detect if MySQL or MariaDB is installed and return version and socket path</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/mysql/connect</code></td><td>Test a database connection with provided credentials and return connection status</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/mysql/databases</code></td><td>List all databases accessible with the provided credentials</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/mysql/tables</code></td><td>List all tables in a specific database with row count and size</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/mysql/query</code></td><td>Execute a SQL query and return results as JSON (SELECT) or affected row count (INSERT/UPDATE/DELETE)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/mysql/dump</code></td><td>Generate a SQL dump of a database or specific tables for backup/export</td></tr>
                    </tbody>
                </table>
<pre><code># Detect MySQL installation
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/mysql/detect | jq .

# Execute a query
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "host": "localhost",
    "user": "root",
    "password": "dbpassword",
    "database": "myapp",
    "query": "SELECT id, name FROM users LIMIT 10"
  }' \
  https://server:8553/api/mysql/query</code></pre>
            </div>

            <!-- AI Agent -->
            <div class="content-section" id="ai">
                <h2>AI Agent</h2>
                <p>Built-in AI assistant for server management. Supports Claude and Gemini models with context-aware health monitoring.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/ai/config</code></td><td>Get AI agent configuration: enabled models, API key status, and system prompt settings</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/ai/config</code></td><td>Update AI agent configuration with API keys, preferred model, and custom system prompts</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/ai/chat</code></td><td>Send a message to the AI agent and receive a response with server-aware context</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/ai/status</code></td><td>Get AI agent health status and recent activity summary</td></tr>
                    </tbody>
                </table>
<pre><code># Chat with the AI agent
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"message":"What is the current disk usage and are any disks close to full?"}' \
  https://server:8553/api/ai/chat

# Check AI agent status
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/ai/status | jq .</code></pre>
            </div>

            <!-- Secrets Manager -->
            <div class="content-section" id="secrets">
                <h2>Secrets Manager</h2>
                <p>Encrypted key-value store for sensitive data such as API tokens, database passwords, and private keys.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/secrets</code></td><td>List all stored secret keys (names only, values are not returned in listings)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/secrets</code></td><td>Store a new secret with a key name and encrypted value</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/secrets/{key}</code></td><td>Retrieve a secret value by key name (returns the decrypted value)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/secrets/{key}</code></td><td>Delete a secret by key name</td></tr>
                    </tbody>
                </table>
<pre><code># List secret keys
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/secrets | jq .

# Store a new secret
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"key":"db_password","value":"s3cur3_p@ssw0rd"}' \
  https://server:8553/api/secrets</code></pre>
            </div>

            <!-- Components & Services -->
            <div class="content-section" id="components">
                <h2>Components &amp; Services</h2>
                <p>Manage system components (Docker, LXC, WolfNet, etc.) and systemd services directly from the API.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/components</code></td><td>List all WolfStack components with installed status, version, and service state</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/components/{name}/install</code></td><td>Install a component (Docker, LXC, WolfNet, Ceph, etc.) on the current node</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/services/{name}/action</code></td><td>Perform a systemd service action: start, stop, restart, enable, or disable</td></tr>
                    </tbody>
                </table>
<pre><code># List components
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/components | jq .

# Restart the nginx service
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{"action":"restart"}' \
  https://server:8553/api/services/nginx/action</code></pre>
            </div>

            <!-- System -->
            <div class="content-section" id="system">
                <h2>System</h2>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/config/export</code></td><td>Export the complete WolfStack configuration as a JSON archive for backup or migration</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/config/import</code></td><td>Import a WolfStack configuration archive to restore settings, mounts, and schedules</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/upgrade</code></td><td>Upgrade WolfStack to the latest version (downloads and replaces the binary, then restarts)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/issues/scan</code></td><td>Scan for system issues: outdated packages, misconfigured services, security warnings, and resource problems</td></tr>
                    </tbody>
                </table>
<pre><code># Export configuration
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/config/export -o wolfstack-config.json

# Scan for issues
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/issues/scan | jq .</code></pre>
            </div>

            <!-- Enterprise API Keys -->
            <div class="content-section" id="apikeys">
                <h2>Enterprise API Keys</h2>
                <div style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,rgba(220,38,38,0.1),rgba(239,68,68,0.05));border:1px solid rgba(220,38,38,0.25);border-radius:8px;padding:8px 16px;margin-bottom:16px;font-size:0.85rem;">
                    <span style="font-size:1.1rem;">&#128273;</span>
                    <span><strong>Enterprise Feature</strong> &mdash; These endpoints require an active <a href="enterprise.php" style="color:#ef4444;font-weight:600;">Enterprise license</a>.</span>
                </div>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/platform/status</code></td><td>Check enterprise license status: valid/expired, customer name, expiry date, and features</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/tokens</code></td><td>List all API keys with name, scopes, creation date, last used, and expiry (key values are masked)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/tokens</code></td><td>Create a new API key with name, scopes, and optional expiry date (returns the raw key once)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/tokens/{id}</code></td><td>Revoke an API key immediately (all requests using this key will be rejected)</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/tokens/scopes</code></td><td>List all available API key scopes with descriptions</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/tokens/events</code></td><td>API key usage audit log: recent requests with key name, endpoint, method, IP, and timestamp</td></tr>
                    </tbody>
                </table>
<pre><code># Create a new API key
curl -X POST -H "X-API-Key: wsk_admin_key..." -H "Content-Type: application/json" \
  -d '{
    "name": "ci-deploy-bot",
    "scopes": ["containers", "appstore"],
    "expires": "2027-01-01"
  }' \
  https://server:8553/api/tokens
{
  "key": { "id": "key_...", "name": "ci-deploy-bot", "scopes": ["containers","appstore"] },
  "raw_key": "wsk_a1b2c3d4e5f6...",
  "message": "Save this key now -- it will not be shown again"
}

# View audit log
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/tokens/events | jq '.[0:5]'</code></pre>
            </div>

            <!-- Nginx (WolfProxy) Configurator -->
            <div class="content-section" id="nginx">
                <h2>Nginx (WolfProxy) Configurator</h2>
                <p>Manage Nginx reverse proxy configurations. Create, edit, enable, and disable site configurations with automatic syntax validation.</p>
                <table class="feature-table" style="width:100%;font-size:0.82rem;">
                    <thead><tr><th style="width:70px;">Method</th><th style="width:340px;">Endpoint</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/configurator/nginx/sites</code></td><td>List all Nginx site configurations with enabled/disabled status and domain names</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/configurator/nginx/sites</code></td><td>Create a new Nginx site configuration with server name, upstream, SSL, and proxy settings</td></tr>
                        <tr><td><code class="method-get">GET</code></td><td><code>/api/configurator/nginx/sites/{name}</code></td><td>Get the full Nginx configuration file contents for a site</td></tr>
                        <tr><td><code class="method-put">PUT</code></td><td><code>/api/configurator/nginx/sites/{name}</code></td><td>Update an Nginx site configuration (replaces the entire config file)</td></tr>
                        <tr><td><code class="method-delete">DELETE</code></td><td><code>/api/configurator/nginx/sites/{name}</code></td><td>Delete an Nginx site configuration file</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/configurator/nginx/sites/{name}/enable</code></td><td>Enable a site by creating a symlink in sites-enabled</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/configurator/nginx/sites/{name}/disable</code></td><td>Disable a site by removing its symlink from sites-enabled</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/configurator/nginx/test</code></td><td>Test the Nginx configuration for syntax errors (equivalent to <code>nginx -t</code>)</td></tr>
                        <tr><td><code class="method-post">POST</code></td><td><code>/api/configurator/nginx/reload</code></td><td>Reload Nginx to apply configuration changes (graceful reload, no downtime)</td></tr>
                    </tbody>
                </table>
<pre><code># List all Nginx sites
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/configurator/nginx/sites | jq .

# Create a reverse proxy site
curl -X POST -H "X-API-Key: wsk_..." -H "Content-Type: application/json" \
  -d '{
    "name": "app-proxy",
    "server_name": "app.example.com",
    "upstream": "http://127.0.0.1:3000",
    "ssl": true,
    "ssl_certificate": "/etc/letsencrypt/live/app.example.com/fullchain.pem",
    "ssl_certificate_key": "/etc/letsencrypt/live/app.example.com/privkey.pem"
  }' \
  https://server:8553/api/configurator/nginx/sites

# Test and reload
curl -X POST -H "X-API-Key: wsk_..." https://server:8553/api/configurator/nginx/test
curl -X POST -H "X-API-Key: wsk_..." https://server:8553/api/configurator/nginx/reload</code></pre>
            </div>

            <!-- Error Handling -->
            <div class="content-section" id="errors">
                <h2>Error Handling</h2>
                <p>All API errors return JSON with an <code>error</code> field and an appropriate HTTP status code:</p>
<pre><code>// 400 Bad Request — invalid parameters
{ "error": "Missing required field: name" }

// 401 Unauthorized — no valid credentials
{ "error": "Invalid or expired API key" }

// 403 Forbidden — wrong scope or missing license
{ "error": "API key does not have permission for this endpoint" }
{ "error": "Enterprise license required" }

// 404 Not Found — resource does not exist
{ "error": "Container not found: abc123" }

// 409 Conflict — resource state conflict
{ "error": "Container is already running" }

// 500 Internal Server Error — unexpected failure
{ "error": "Failed to connect to Docker socket" }</code></pre>
                <p>Successful responses return <code>200 OK</code> with a JSON body. Mutations (POST, PUT, DELETE) typically include a <code>message</code> field confirming the action:</p>
<pre><code>{ "message": "Container started successfully" }
{ "message": "Backup schedule created", "id": "sched_abc123" }</code></pre>
            </div>

            <!-- Rate Limiting -->
            <div class="content-section" id="ratelimiting">
                <h2>Rate Limiting</h2>
                <p>WolfStack applies rate limiting to protect against abuse:</p>
                <ul>
                    <li><strong>Login endpoint</strong> &mdash; Maximum 10 attempts per 5 minutes per IP address. Lockouts clear automatically after the window expires.</li>
                    <li><strong>API endpoints</strong> &mdash; No hard rate limit on authenticated API requests. However, resource-intensive operations (backups, migrations, updates) are serialized to prevent overloading the system.</li>
                    <li><strong>Session lifetime</strong> &mdash; Session cookies expire after 8 hours. Expired sessions are cleaned up every 5 minutes.</li>
                    <li><strong>API key expiry</strong> &mdash; Enterprise API keys can have an optional expiry date. Expired keys are rejected immediately.</li>
                </ul>
            </div>

            <!-- License Installation -->
            <div class="content-section" id="license">
                <h2>Installing an Enterprise License</h2>
                <p>Enterprise licenses are issued as a signed JSON file. To activate API key management:</p>
                <ol style="margin:12px 0;padding-left:20px;font-size:0.9rem;line-height:1.8;">
                    <li>Obtain your license key file from <a href="https://wolf.uk.com">Wolf Software Systems</a></li>
                    <li>Save it to <code>/etc/wolfstack/license.key</code> on your server</li>
                    <li>Restart WolfStack: <code>sudo systemctl restart wolfstack</code></li>
                    <li>Go to <strong>Settings &rarr; API Keys</strong> to create your first key</li>
                </ol>
<pre><code># Save the license file
sudo tee /etc/wolfstack/license.key &lt;&lt; 'EOF'
{
  "payload": "eyJjdXN0b21lci...",
  "signature": "dGhpcyBpcyBh..."
}
EOF

# Restart to activate
sudo systemctl restart wolfstack

# Verify the license
curl -s -H "X-API-Key: wsk_..." https://server:8553/api/platform/status | jq .</code></pre>
            </div>

            <div class="page-nav"><a href="wolfstack-security.php" class="prev">&larr; Security</a><a href="enterprise.php" class="next">Enterprise Licensing &rarr;</a></div>

            </div><!-- end main content column -->
            </div><!-- end api-grid -->

    </main>
</div>

<!-- Search overlay (from footer, without the footer element) -->
<div class="search-overlay" id="search-overlay" onclick="if(event.target===this)closeSearch()">
    <div class="search-dialog">
        <div class="search-input-wrap">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="search-input" placeholder="Search documentation..." autocomplete="off" spellcheck="false">
            <kbd class="search-esc">Esc</kbd>
        </div>
        <div class="search-results" id="search-results"></div>
    </div>
</div>

<script src="script.js?v=<?php echo filemtime(__DIR__ . '/script.js'); ?>"></script>
</body>
</html>
