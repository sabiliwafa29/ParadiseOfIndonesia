import { cn } from "@/lib/utils";

interface TabsProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const Tabs = React.forwardRef<HTMLDivElement, TabsProps>({
  className: "w-full",
  ...props,
}) => {
  return (
    <div className={cn("w-full", props.className)} {...props} />
  );
});

Tabs.displayName = "Tabs";

interface TabsListProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const TabsList = React.forwardRef<HTMLDivElement, TabsListProps>({
  className: "flex border-b bg-muted/50",
  ...props,
}) => {
  return (
    <div className={cn("flex border-b bg-muted/50", props.className)} {...props} />
  );
});

TabsList.displayName = "TabsList";

interface TabsTriggerProps extends React.HTMLAttributes<HTMLButtonElement> {
  className?: string;
  value: string;
  asChild?: boolean;
}

const TabsTrigger = React.forwardRef<HTMLButtonElement, TabsTriggerProps>({
  className: "flex-1 rounded-md px-2 py-1.5 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 transition-colors hover:bg-muted/50 disabled:opacity-50 disabled:pointer-events-none",
  value: "",
  ...props,
}) => {
  const { className, value, asChild, children, ...propsRest } = props;
  return asChild ? (
    <button className={cn("flex-1 rounded-md px-2 py-1.5 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 transition-colors hover:bg-muted/50 disabled:opacity-50 disabled:pointer-events-none", className)} {...propsRest} />
  ) : (
    <button className={cn("flex-1 rounded-md px-2 py-1.5 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 transition-colors hover:bg-muted/50 disabled:opacity-50 disabled:pointer-events-none", className)} value={value} {...propsRest} />
  );
});

TabsTrigger.displayName = "TabsTrigger";

interface TabsContentProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const TabsContent = React.forwardRef<HTMLDivElement, TabsContentProps>({
  className: "p-4",
  ...props,
}) => {
  return (
    <div className={cn("p-4", props.className)} {...props} />
  );
});

TabsContent.displayName = "TabsContent";

export { Tabs, TabsList, TabsTrigger, TabsContent };
